<?php
/**
 * 删除指定目录下的指定后缀文件
 * @param $dir 指定目录
 * @param $ext 指定后缀 默认未空，即所有非目录文件
 * @return bool
 */

 function scanDirs($dir, $ext='', $pre='')
 {
 	if ( !is_dir($dir) ) {
		echo 'not dir';
		return false;
	}
	if ( $handle = opendir($dir) ) {
		chdir($dir);
		while ( false !== ( $file = readdir($handle) ) ) {
			if ( $file != '.' && $file != '..') {
				if ( is_dir($file) ) {
					scanDirs($file, $ext, $pre);
				} else {
					if ( empty($ext) ) {
						if ( empty($pre) ) {
							echo 'delete->',$file.chr(10);
							unlink($file);
						} else if ( strpos($file, $pre) === 0 ) {
							echo 'delete->',$file.chr(10);
							unlink($file);
						}
					} else {
						$explode = explode('.', $file);
						$fileExt = end($explode);
						if ($fileExt == $ext) {
							echo 'delete->',$file.chr(10);
							unlink($file);
						}
					}
				}
			}
		}
		chdir('../');
 		closedir($handle);
		return true;
 	}
 }

$dir = 'html';
scanDirs($dir, '', '.');
