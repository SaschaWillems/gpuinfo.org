<?php
/**
 *
 * GPU hardware database
 *
 * Copyright (C) 2016-2023 by Sascha Willems (www.saschawillems.de)
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
?>

<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Sascha Willems">
	<title>GPU hardware info database launchpad</title>
	<link href="./external/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
</head>

<body>

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/">
					<img class="site-logo" src="./images/gpuinfo.png" height="48px">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="https://vulkan.gpuinfo.org">Vulkan</a></li>
					<li><a href="https://opencl.gpuinfo.org">OpenCL</a></li>
					<li><a href="https://opengl.gpuinfo.org">OpenGL</a></li>
					<li><a href="https://opengles.gpuinfo.org">OpenGL ES</a></li>
					<li><a href="https://android.gpuinfo.org">Android</a></li>
					<li><a href="./about.php">About</a></li>
				</ul>
			</div>
		</div>
	</nav>
