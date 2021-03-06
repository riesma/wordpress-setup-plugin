<?php
/*
Plugin Name:   Riesma Setup
Plugin URI:    https://github.com/riesma/wordpress-setup-plugin
Description:   Adding custom post types, sorting and hiding admin menu items.
Version:       1.1.2
Author:        Richard van Aalst
Author URI:    http://riesma.nl/

Copyright (C) 2012-2014 Richard van Aalst
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

if( ! defined( 'ABSPATH' ) ) exit;


// Initialise the setup
require_once( 'includes/class.main.php' );

Riesma::init();


?>