<?php
/**
 *
 * GPU hardware database
 *
 * Copyright (C) 2016-2022 by Sascha Willems (www.saschawillems.de)
 *
 * This code is free software, you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public
 * License version 3 as published by the Free Software Foundation.
 *
 * Please review the following information to ensure the GNU Lesser
 * General Public License version 3 requirements will be met:
 * http://www.gnu.org/licenses/agpl-3.0.de.html
 *
 * The code is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 * PURPOSE.  See the GNU AGPL 3.0 for more details.
 *
 */

require('header.php');
?>

<div class="site-wrapper content">

	<div class="site-wrapper-inner">

		<div class="container">

			<div class="jumbotron">
				<center>
					<a href="about.php"><img src="./images/gpuinfo.png" class="img-responsive site-logo" width="320px"></a>
					<h4 style="padding-top: 20px;">Home of the community driven hardware databases for Khronos APIs.</h4>
				</center>
			</div>

			<div class="flex-container">
				<div class="flex-item">
					<a href="https://opengl.gpuinfo.org" target="_blank"><img src="./images/opengl.png" class="img-responsive"></a>
					<a href="https://opengl.gpuinfo.org" target="_blank">
						<h3><span class="text-muted reportcount-gl"> Reports online</span></h3>
					</a>
					<p class="lead infotext">
						OpenGL® is a widely adopted 2D and 3D graphics API available on many desktop platforms. It
						features hundreds of extensions to support the latest GPU features.
					</p>
				</div>

				<div class="flex-item">
					<a href="https://vulkan.gpuinfo.org" target="_blank"><img src="./images/vulkan.png" class="img-responsive"></a>
					<a href="https://vulkan.gpuinfo.org" target="_blank">
						<h3><span class="text-muted reportcount-vk"> Reports online</span></h3>
					</a>
					<p class="lead infotext">
						<a href="https://www.khronos.org/vulkan/">Vulkan</a> is the new generation, open standard
						API for high-efficiency access to graphics and compute on modern GPUs, available on desktop
						and mobile platforms.
					</p>
				</div>

				<div class="flex-item">
					<a href="https://opengles.gpuinfo.org" target="_blank"><img src="./images/opengles.png" class="img-responsive"></a>
					<a href="https://opengles.gpuinfo.org" target="_blank">
						<h3> <span class="text-muted reportcount-gles"> Reports online</span></h3>
					</a>
					<p class="lead infotext">
						OpenGL ES is a 2D and 3D graphics API for embedded devices. It's widely used in the mobile
						space and available on almost any mobile device.
					</p>
				</div>

				<div class="flex-item">
					<a href="https://opencl.gpuinfo.org" target="_blank"><img id="opencl-logo" src="./images/opencl.png" class="img-responsive"></a>
					<a href="https://opencl.gpuinfo.org" target="_blank">
						<h3> <span class="text-muted reportcount-cl"> Reports online</span></h3>
					</a>
					<p class="lead infotext" style="text-align:justify;">
						<a href="https://www.khronos.org/opencl/">OpenCL™</a> is an open standard for cross-platform, parallel programming of diverse accelerators found in supercomputers, cloud servers, personal computers, mobile devices and embedded platforms.
					</p>
				</div>					

			</div>

		</div>

		<hr class="featurette-divider">

		<footer>
			<!-- Trademarks -->
			<p align="center" class="copyrightexternal">Khronos® and Vulkan® are registered trademarks of The Khronos Group Inc.</p>
			<p align="center" class="copyrightexternal">OpenGL® is a registered trademark and the OpenGL ES™ logo are trademarks of Hewlett Packard Enterprise, and OpenCL™ is a trademark of Apple Inc., used under license by Khronos.</p>
			<hr class="featurette-divider">
			<center>
				<div style='width:75%'>
					<a href="privacypolicy.html">Privacy policy</a><br /><br />
					Copyright (c) 2016-2023 by <a href="https://www.saschawillems.de">Sascha Willems</a><br>
					<a href="#">Back to top</a>
				</div>
			</center>
		</footer>

	</div>

</div>

</div>

<script src="./external/jquery-2.1.4.min.js"></script>
<script src="./external/bootstrap/js/bootstrap.min.js"></script>

<script>
	$(document).ready(function () {

		// Vulkan report count
		$.ajax({
			type: 'GET',
			url: 'https://vulkan.gpuinfo.org/api/v3/getreportcount.php',
			dataType: 'json',
			crossDomain: true,
			success: function (data) {
				$('.reportcount-vk').before(data.count);
			}
		});

		// OpenGL report count
		$.ajax({
			type: 'GET',
			url: 'https://opengl.gpuinfo.org/api/v1/getreportcount.php',
			dataType: 'json',
			crossDomain: true,
			success: function (data) {
				$('.reportcount-gl').before(data.count);
			}
		});

		// OpenGL ES report count
		$.ajax({
			type: 'GET',
			url: 'https://opengles.gpuinfo.org/api/v1/getreportcount.php',
			dataType: 'json',
			crossDomain: true,
			success: function (data) {
				$('.reportcount-gles').before(data.count);
			}
		});

		// OpenCL report count
		$.ajax({
			type: 'GET',
			url: 'https://opencl.gpuinfo.org/api/v1/getreportcount.php',
			dataType: 'json',
			crossDomain: true,
			success: function (data) {
				$('.reportcount-cl').before(data.count);
			}
		});

	});
</script>

</body>

</html>