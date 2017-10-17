<head>
	<title>gpuinfo.org - &copy; 2016-2017 by Sascha Willems</title>	
	
	<link rel="stylesheet" type="text/css" href="./external/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="./external/css/dataTables.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="./external/css/fixedHeader.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="./external/css/responsive.bootstrap.min.css"/>

	<link rel="stylesheet" type="text/css" href="./vulkan/style.css">
	<link rel="stylesheet" type="text/css" href="./style.css">

	<script type="text/javascript" src="./external/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="./external/bootstrap.min.js"></script>
	<script type="text/javascript" src="./external/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="./external/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="./external/dataTables.fixedHeader.min.js"></script>
	<script type="text/javascript" src="./external/responsive.bootstrap.min.js"></script>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="gpuinfo.org" />
    <meta name="twitter:creator" content="Sascha Willems" />    

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@SaschaWillems2" />
    <meta name="twitter:title" content="Android on gpuinfo.org" />
    <meta name="twitter:description" content="Combined Android device reports from the Vulkan and OpenGL ES hardware databases." />
    <meta name="twitter:image" content="https://android.gpuinfo.org/images/gpuinfo_square.png" />
</head>
<body>

<?php
    include './dbconfig.php';
    DB::connect();

	// Filter criteria
	$filter_apis = $_GET['apis'];

    $devices_es = array();

    $stmnt = DB::$connection_vk->prepare("SELECT device, ver, devicename, id, retailbranding, marketingname
        FROM (SELECT dpf.value as device, apiversion as ver, devicename, id, gdl.retailbranding, gdl.marketingname FROM reports r right join deviceplatformdetails dpf on r.id = dpf.reportid join googledevicelist gdl on gdl.model = dpf.value where dpf.platformdetailid = 4) as h
        GROUP BY device");            
    $stmnt->execute();
    $devices_vk = $stmnt->fetchAll();

    $stmnt = DB::$connection_es->prepare("SELECT dev, ver, GL_RENDERER, ID, retailbranding, marketingname
        FROM (SELECT r.device as dev, concat(ESVERSION_MAJOR, '.', ESVERSION_MINOR) as ver, GL_RENDERER, ID, gdl.retailbranding, gdl.marketingname FROM reports r join googledevicelist gdl on gdl.model = r.device ORDER BY ver DESC) AS h
        GROUP BY dev");
    $stmnt->execute();
    $devices_es = $stmnt->fetchAll();

    $devicelist = array();

    foreach ($devices_vk as $device) {
        $devicelist[$device[0]]["name"] = mb_strimwidth($device[0], 0, 35, "...");
        $devicelist[$device[0]]["vk"] = true;
        $devicelist[$device[0]]["vk_ver"] = $device[1];
        $devicelist[$device[0]]["vk_r"] = $device[2];
        $devicelist[$device[0]]["vk_id"] = $device[3];
        if (($device[4] == "") or ($device[5] == "")) {
            $devicelist[$device[0]]["prodname"] = "<font color='#CACACA'>unknown</font>";    
        } else {
            $devicelist[$device[0]]["prodname"] = $device[4]." ".$device[5];
        }
    }

    foreach ($devices_es as $device) {
        if (trim($device[0]) == "")
            continue;
        $devicelist[$device[0]]["name"] = mb_strimwidth($device[0], 0, 35, "...");
        $devicelist[$device[0]]["es"] = true;
        $devicelist[$device[0]]["es_ver"] = $device[1];
        $devicelist[$device[0]]["es_r"] = $device[2];
        $devicelist[$device[0]]["es_id"] = $device[3];
        if (($device[4] == "") or ($device[5] == "")) {
            $devicelist[$device[0]]["prodname"] = "<font color='#CACACA'>unknown</font>";    
        } else {
            $devicelist[$device[0]]["prodname"] = $device[4]." ".$device[5];
        }
    }

    ksort($devicelist);
?>
<center>	
	<div class='tablediv' style='width:auto; display: inline-block;'>
<center>
    <a href="http://gpuinfo.org"><img src="./images/gpuinfo.png" height="128px" style="padding-bottom:25px;"></a><br>
    Combined Android device data from the <a href="https://vulkan.gpuinfo.org">Vulkan</a> and <a href="http://opengl.gpuinfo.org/">OpenGL ES</a> databases.<br>
    <br><br>
</center>
        
    <div id="loading">
        <span>Fetching data...</span>
    </div>

    <table id="devices" class="table table-striped table-bordered table-hover responsive" style="width:auto; display:none;">
    <thead>
        <tr>
            <th>Model</th>
            <th>Retail name</th>
            <th>GPU</th>
            <th>VK</th>
            <th>GLES</th>
            <th class="skipx">APIs</th>
        </tr>
        <tr>
            <th>Model</th>
            <th>Retail name</th>
            <th>GPU</th>
            <th>VK</th>
            <th>GLES</th>
            <th class="skipx">APIs</th>
        </tr>        
    </thead>
    <tbody>
<?php
    foreach ($devicelist as $device) {
        echo "<tr>";
        echo    "<td>".$device["name"]."</td>";
        echo    "<td>".$device["prodname"]."</td>";
        /*
        echo    "<td align='center' valign='middle'>";
        if ($device["vk"]) { 
            echo "<td style='background:#00FF00;'>";
//            echo "<img src='../vulkan/icon_check.png' width='24px'>";
        } else {
            echo "<td>";
        }
        */
        $apis = array();
        if ($device["vk"]) { $apis[] = "VK"; }
        if ($device["es"]) { $apis[] = "GLES"; }
        echo    "<td>";
        if ($device["vk_r"]) {
            echo mb_strimwidth($device["vk_r"], 0, 20, "...");
        } else {
            echo mb_strimwidth($device["es_r"], 0, 20, "...");
        }
        echo    "</td>";
        echo "<td align='center'>";
        echo ($device["vk"]) ? "<font color='green'><a href='https://vulkan.gpuinfo.org/displayreport.php?id=".$device["vk_id"]."' target='_blank' style='color:green;'>".$device["vk_ver"]."</a></font>" : " ";        
        echo    "</td>";
        echo    "<td align='center'>";
        echo ($device["es"]) ? "<font color='green'><a href='http://opengles.gpuinfo.org/gles_generatereport.php?reportID=".$device["es_id"]."' target='_blank' style='color:green;'>".$device["es_ver"]."</a></font>" : " ";        
        echo    "</td>";
        echo    "<td align='center'>";
        echo    implode(',', $apis);
        echo    "</td>";
        echo "</tr>";
    }
?>
    </tbody>
    </table>
    </div>

    </center>

    <script>
        <?php 
            if ($filter_apis) {
                echo "var filter_apis = \"".$filter_apis."\"";
            } else {
                echo "var filter_apis = null";
            } 
        ?>

        $(document).ready(function() {
            var table = $('#devices').DataTable({
                "pageLength" : -1,
                "paging" : false,
                "stateSave": false, 
                "searchHighlight" : true,	
                "dom": 'lrtip',			
                "bInfo": true,	
                "order": [[ 5, "desc"], [1, "asc" ]],
<?php 
    echo "\"searchCols\": [null, null, null, null, null, ";
    if ($filter_apis) {
        echo "{ \"search\": \"".$filter_apis."\" }";
    } else {
        echo "null";
    }
    echo "]";
?>                
            });
            $('#loading').hide();
            $('#devices thead th').each( function (i) {
                var title = $('#devices thead th').eq( $(this).index() ).text();
                var cl  = $('#devices thead th').eq( $(this).index() ).attr("class");
                if ((title !== '')) {
                    var w = (title != 'Retail name') ? 120 : 240;
                        filterparam = '';
                        if ((title == 'APIs') && (filter_apis)) {
                            filterparam = filter_apis;
                        }
                        if (cl != "skip") {
                            $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" style="width: '+w+'px;" class="filterinput" value="'+filterparam+'"></input>' );
                        }
                }
            }); 
            $(table.table().container() ).on('keyup', 'thead input', function () {
                table
                    .column($(this).data('index'))
                    .search(this.value)
                    .draw();
            });		                                    
            $('#devices').show();
        } );
	    function stopPropagation(evt) {
			if (evt.stopPropagation !== undefined) {
				evt.stopPropagation();
			} else {
				evt.cancelBubble = true;
			}
		}        	
    </script>

<?php  
    DB::disconnect();
?>

    <footer>
        <!-- Trademarks -->	
        <p align="center" class="copyrightexternal">Vulkan and the Vulkan logo are trademarks of the Khronos Group Inc.</p>
        <p align="center" class="copyrightexternal">OpenGL ES® is a registered trademark and the OpenGL ES logo is a trademark of Silicon Graphics Inc. used by permission by Khronos.</p>
        <hr class="featurette-divider">
        <center>
        <div style='width:75%'>
            Copyright (c) 2016-2017 by <a href="http://www.saschawillems.de">Sascha Willems</a><br>
            <a href="#">Back to top</a>
        </div>
        </center>
    </footer>

</body>