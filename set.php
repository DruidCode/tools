<?php
/**
 *移动和联通、电信号码分开
 *
 */
$mobiles = file("all.txt");
$ymbi = "";
$qmbi = "";
foreach($mobiles as $mob)
{
        $tmob = trim($mob);
        $sub = substr($tmob,0,3);
            $array = array('134','135','136','137','138','139','150','151','152','157','158','159','182','183','187','188','147');
            //$array = array('133','153','180','181','189');
                if(in_array($sub,$array))
                        {
                                    $ymbi.=$tmob."\r\n";
                                        }
                    else
                            {
                                        $qmbi.=$tmob."\r\n";
                                            }
}

$f = fopen("yd.txt",'a');
fwrite($f,$ymbi);
fclose($f);

$t = fopen("qt.txt",'a');
fwrite($t,$qmbi);
fclose($t);

?>
