<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Image Editor</title>
      <script src="./Image_Resizer_files/prototype-1.6.0.2.js" type="text/javascript"></script>
      <script src="./Image_Resizer_files/scriptaculous.js" type="text/javascript"></script>
      <script type="text/javascript" src="./Image_Resizer_files/slider.js"></script>
      <link rel="stylesheet" type="text/css" href="./Image_Resizer_files/css.css" media="screen">

      <?php

        function getDPIImageMagick($filename) {
            $cmd = 'identify -quiet -format "%x" '.$filename;       
            @exec(escapeshellcmd($cmd), $data);
            if($data && is_array($data)){
                $data = explode(' ', $data[0]);

                if($data[1] == 'PixelsPerInch'){
                    return $data[0];
                }elseif($data[1] == 'PixelsPerCentimeter'){
                    $x = ceil($data[0] * 2.54);
                    return $x;
                }elseif($data[1] == 'Undefined'){
                    return $data[0];
                }                       
            }
            return 'n/a';
        }

        if(isset($_GET['file']) && $_GET['file'] != '') {
            $img = $_GET['file'];
        }
        else {
            $img = 'uploads/sub2.jpg';
        }
        list($width, $height, $mime) = getimagesize($img);
        $aspect_ratio = $height / $width;
        $dpi = getDPIImageMagick($img);
      ?>

      <script type="text/javascript">

         function cb(params) {
             if (params.state == "on") {
                 setCookie("priority", "true",365);
                 $('pone').style.display="none";  
                 $('ptwo').style.visibility="visible";
                 plussed(); 
            } 
            else {
                 setCookie("priority", "",365);
            }
         }

         function checkPriority() {
             var priority=getCookie("priority");
             
             if (priority!=null && priority!=""){
                 return true;
             }
             return false;
         }

         function setCookie(cookieName,cookieValue,nDays) {
             var today = new Date();
             var expire = new Date();
             if (nDays==null || nDays==0) nDays=1;
             expire.setTime(today.getTime() + 3600000*24*nDays);
             document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString();
         }

         function getCookie(cookieName) {
             var theCookie=" "+document.cookie;
             var ind=theCookie.indexOf(" "+cookieName+"=");
             if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
             if (ind==-1 || cookieName=="") return "";
             var ind1=theCookie.indexOf(";",ind+1);
             if (ind1==-1) ind1=theCookie.length; 
             return unescape(theCookie.substring(ind+cookieName.length+2,ind1));
         }
         
      </script>
   </head>

   <body style="cursor: default;">
      <div id="header">
      <div id="container">
         <script>
            function subfxn() {
              progress();
              return true;
            }
            function hideprogress() {
              var i = $('sub');
                    $('loader2').style.display='none';
              i.value=' Save ';
            }
            function progress() {
                    var b = $('loader2');
                    b.style.display='inline';
              var i = $('sub');
              i.value='Please Wait';
            }
         </script>
         <script type="text/javascript">
            function init() {
              $('cnone');
              $('cnone').checked = true;
                    hideprogress();
              setCropType(0,0,true);
            }
            
            // function set_image_size() { }

            // window.onload = set_image_size;
            window.onunload = init;
            
         </script>
         <div style="font-size: 18px; margin-top: 10px;">
            Image Editor
            <?php if(isset($_GET['product_name']) && $_GET['product_name'] != '') {
              echo ' - ' . $_GET['product_name'] . ' - Product Code: ' . $_GET['product_code'];
            } ?>
         </div>
            <div id="track1" style="position: fixed; top: 35px; left: 7px;">
               <div id="handle1" class="selected" style="left: 359px; margin-bottom: 10px; position: relative;">
                  <img src="./Image_Resizer_files/images/handle.png">
               </div>
            </div>
            <div style="clear: both;"></div>    
            <br />     
               <div style="font-size: 12px; padding: 0px; margin: 0px;">
                  <form action="post2.php" method="post"><br />
                    <div id="uiwrap" >
                      <span id="msg"></span>
                      <div id="scalewrap">
                         <div id="scaleme" style="width: 286.995px;">
                            <img id="tempimage" src="<?php echo $img;?>" width="100%" style="margin-top: 1px; margin-left: 1px;">
                            <img id="loading" src="./Image_Resizer_files/images/ajaxloadblue.gif" style="visibility: hidden; position: absolute; top: 0px; left: 0px;"> 
                            <span id="histogramspan" style="display: none; position: absolute; top: 0px; left: 540; padding: 0px; margin: 0px;">
                                <span style="position: absolute; top: 0px; left: 120px; font-size: 10px;">
                                <div id="htrack" style="width:257px;background-color:#aaa;height:5px;">
                                  <div id="hhandle1" style="width: 5px; height: 10px; background-color: rgb(0, 0, 0); border: 0px solid black; cursor: move; position: relative; left: 0px;" class="selected"> </div>
                                  <div id="hhandle2" style="margin-top: -12px; width: 5px; height: 10px; background-color: rgb(204, 204, 204); border: 0px solid black; cursor: move; left: 126px; position: relative;" class=""> </div>
                                  <div id="hhandle3" style="margin-top: -12px; width: 5px; height: 10px; background-color: rgb(255, 255, 255); border: 0px solid black; cursor: move; left: 252px; position: relative;" class=""> </div>
                               </div>
                            </span>
                         </div>
                         <div id="cot" class="co" style="top: 0px; left: 0px; width: 287px; display: none;"></div>
                         <div id="cor" class="co" style="display: none;"></div>
                         <div id="col" class="co" style="left: 0px; display: none;"></div>
                         <div id="cob" class="co" style="left: 0px; width: 287px; display: none;"></div>
                         <div id="croptop" class="cropborder" onmousedown="rc(&#39;n&#39;);" style="height: 3px; display: none;"></div>
                         <div id="cropleft" class="cropborder" onmousedown="rc(&#39;w&#39;);" style="width: 3px; display: none;"></div>
                         <div id="cropright" class="cropborder" onmousedown="rc(&#39;e&#39;);" style="width: 3px; display: none;"></div>
                         <div id="cropbottom" class="cropborder" onmousedown="rc(&#39;s&#39;);" style="height: 3px; display: none;"></div>
                         <div id="cnw" class="cropborder" onmousedown="rc(&#39;nw&#39;);" style="width: 6px; height: 6px; display: none;"></div>
                         <div id="cne" class="cropborder" onmousedown="rc(&#39;ne&#39;);" style="width: 6px; height: 6px; display: none;"></div>
                         <div id="csw" class="cropborder" onmousedown="rc(&#39;sw&#39;);" style="width: 6px; height: 6px; display: none;"></div>
                         <div id="cse" class="cropborder" onmousedown="rc(&#39;se&#39;);" style="width: 6px; height: 6px; display: none;"></div>
                         <div id="cropme" onmousedown="cropMouseDown();" style="left: 0px; display: none;"></div>
                    </div>
                 </div>
                 <input type="hidden" name="edit_image"  value="<?php echo $img;?>" />
                 <input type="hidden" name="edit_image_mime" id="edit_image_mime"  value="<?php echo $mime;?>" />
                 <input type="hidden" name="orig_width"  value="<?php echo $width;?>" />
                 <input type="hidden" name="orig_height" value="<?php echo $height;?>" />
                 <input type="hidden" name="dpi" value="<?php echo $dpi;?>" />
                 <input type="hidden" name="product_name" value="<?php echo $_GET['product_name'];?>" />
                 <input type="hidden" name="product_code" value="<?php echo $_GET['product_code'];?>" />
                 <input type="hidden" name="product_id"   value="<?php echo $_GET['product_id'];?>" />
                 <input type="hidden" name="product_save" value="<?php echo $_GET['product_save'];?>" />

                  <div id="toolbar" style="position: fixed; top: 35px; right: 10px; border: 1px solid #aaaaaa; padding: 5px; background-color: #f7f7f7; width: 210px; cursor: move;">

                      <div class="ribbonitem2" >
                         <span style="font-size: 18px; font-weight: bold;">Original</span> 
                         <div id="wcon"><input style="font-size: 18px; width: 55px;" type="text" id="wo" readonly value="<?php echo $width;?>"></div> x
                         <div id="hcon"><input style="font-size: 18px; width: 55px;" type="text" id="ho" readonly value="<?php echo $height;?>"></div>
                      </div>
                      <div style="clear: both;"></div>   

                      <div class="ribbonitem2">
                         <span style="font-size: 18px; font-weight: bold;">Scaled&nbsp;&nbsp;</span>
                         <div id="wcon"><input style="font-size: 18px; width: 55px;" type="text" name="igw" id="w" onkeyup="changeWidth();" value="<?php echo $width;?>"></div> x
                         <div id="hcon"><input style="font-size: 18px; width: 55px;" type="text" name="igh" id="h" onkeyup="changeHeight();" value="<?php echo $height;?>"></div>
                      </div>                
                      <div style="clear: both;"></div> 

                      <div class="ribbonitem2" >
                         Resolution: <?php echo $dpi;?> (dpi)
                      </div>
                      <div style="clear: both;"></div>   

                      <!-- <div class="ribbonitem2"> -->
                        <div id="besideMouse"></div>
                      <!-- </div> -->
                      <!-- <div style="clear: both;"></div> -->
                      <hr />

                      <div class="ribbonitem2">
                         <span>
                         Crop 
                         <!-- <span id="cropcoords" style="display: none;"></span> -->
                         <label><input type="radio" id="cnone" name="crop" value="none" checked="" onclick="setCropType(0,0,true);">Off</label>
                         <label><input type="radio" id="cb" name="crop" value="sq" onclick="setCropType(5,5,true);">Square</label>
                         <label><input type="radio" id="ca" name="crop" value="free" onclick="setCropType(-1,-1,true);"> Free</label>
                         <input type="radio" id="cc" name="crop" value="4x6" onclick="setCropType(6,4,true);" style="display: none;"> <!-- 4x6 -->
                         <input type="radio" id="cd" name="crop" value="man" onclick="setManualCrop();" style="display: none;"><!-- Manual: -->
                         <input type="text" disabled="" id="aspectWidth" name="aspectWidth" value="5" onkeyup="changeAspect();" style="display: none;"> <!-- X -->
                         <input type="text" disabled="" id="aspectHeight" name="aspectHeight" value="7" onkeyup="changeAspect();" style="display: none;">
                         <input type="checkbox" id="cover" name="cover" onclick="doCover();" style="display: none;" >
                         </span>
                      </div>

                      <script type="text/javascript">
                        
                        function action_image(action, param) {
                            var http = false;
                            if(navigator.appName == "Microsoft Internet Explorer") {
                              http = new ActiveXObject("Microsoft.XMLHTTP");
                            } else {
                              http = new XMLHttpRequest();
                            }

                            var tempimage_src = document.getElementById('tempimage').getAttribute('src');
                            var image_mime = document.getElementById('edit_image_mime').value;
                            http.open("GET", 'action_image.php?image='+tempimage_src+'&param='+param+'&mime='+image_mime+'&action='+action);

                            http.onreadystatechange=function() {
                              if(http.readyState == 4) {
                                return http.responseText;
                              }
                            }
                            http.send(null);
                            location.reload();
                        }
                      </script>
                      <div style="clear: both;"></div>

                      <div class="ribbonitem2" >
                          <span >Rotate</span>
                          <input type="button" onclick="action_image('rotate', 90); return false;" style="background: url('./Image_Resizer_files/images/rotate-left.png') no-repeat; cursor: pointer; border: 1px solid #dddddd; width: 25px; border: 1px solid #dddddd;  " />
                          <input type="button" onclick="action_image('rotate', 270); return false;" style="background: url('./Image_Resizer_files/images/rotate-right.png') no-repeat; cursor: pointer; border: 1px solid #dddddd; width: 25px; border: 1px solid #dddddd;  " />
                      </div>
                      <div style="clear: both;"></div>

                      <div class="ribbonitem2">
                         <input type="checkbox" id="histogram" name="histogram" onclick="displayHistogram();" style="display: none;">
                         Brightness
                         <select id="brightness_select" name="brightness_select" onchange="action_image('brightness', this.value); return false;">
                            <?php for($i = -50; $i <= 50; $i+=5) { ?>
                              <option value="<?php echo $i;?>" <?php if($i == 0) echo ' selected ';?>>
                                <?php if($i < 0) echo 'Dark '; elseif($i > 0) echo 'Light '; else echo 'Same '; ?>
                                (<?php if($i != 0) echo abs($i/5); else echo '0';?>)
                              </option>  
                            <?php } ?>
                         </select>
                      </div>
                      <div style="clear: both;"></div>

                      <div class="ribbonitem2">
                         Contrast
                         <select id="contrast_select" name="contrast_select" onchange="action_image('contrast', this.value); return false;">
                            <?php for($i = -50; $i <= 50; $i+=5) { ?>
                              <option value="<?php echo $i;?>" <?php if($i == 0) echo ' selected ';?>>
                                <?php if($i < 0) echo 'Dark '; elseif($i > 0) echo 'Light '; else echo 'Same '; ?>
                                (<?php if($i != 0) echo abs($i/5); else echo '0';?>)
                              </option>  
                            <?php } ?>
                         </select>
                      </div>
                      <div style="clear: both;"></div>

                      <div class="ribbonitem2">
                        <label><input type="checkbox" name="pad_tb" /> Add top-bottom padding</label><br />
                        <label><input type="checkbox" name="pad_rl" /> Add right-left padding</label>
                      </div>
                      <div style="clear: both;"></div>

                      <div id="buttonwrap">
                        <input id="sub" type="submit" value=" Save " onclick12="return subfxn();" /><br /><br /><br />
                        <input type="button" value=" Cancel " onclick="window.close();" style="float: left; margin-left: 12px;" />
                        <div id="loader2" style="display: none;"><img src="./Image_Resizer_files/images/ajaxloadblue.gif"></div>
                      </div>

                </div>

                 <input type="hidden" name="file" value="bf86e5feb23b35ff6b66e4348dca8851.jpg">
                 <input type="hidden" name="width" id="hidw" value="<?php echo $width;?>">
                 <input type="hidden" name="height" id="hidh" value="<?php echo $height?>">
                 <input type="hidden" name="fcx" id="fcx" value="-Infinity">
                 <input type="hidden" name="fcy" id="fcy" value="-Infinity">
                 <input type="hidden" name="fcw" id="fcw" value="NaN">
                 <input type="hidden" name="fch" id="fch" value="NaN">
                 <input type="hidden" name="fcon" id="fcon" value="0">
                 <input type="hidden" name="actions" id="actions" value="">
                 <input type="hidden" name="grv" id="grv" value="0">
                 <input type="hidden" name="hautolevel" id="hautolevel" value="0">
                 <input type="hidden" name="hautowhite" id="hautowhite" value="0">
                 <input type="hidden" name="hiso" id="hiso" value="0">
                 <input type="hidden" name="hlomo" id="hlomo" value="0">
                 <input type="hidden" name="hvig" id="hvig" value="0">
                 <input type="hidden" name="hlomoy" id="hlomoy" value="0">
                 <input type="hidden" name="hknox" id="hknox" value="0">
                 <input type="hidden" name="hfahr" id="hfahr" value="0">
                 <input type="hidden" name="hcelsius" id="hcelsius" value="0">
                 <input type="hidden" name="hstove" id="hstove" value="0">
                 <input type="hidden" name="sepv" id="sepv" value="0">
                 <input type="hidden" name="mirrorv" id="mirrorv" value="0">
                 <input type="hidden" name="gammav" id="gammav" value="0">
                 <input type="hidden" name="whitev" id="whitev" value="100">
                 <input type="hidden" name="blackv" id="blackv" value="0">
                 <input type="hidden" name="satv" id="satv" value="1">
                 <input type="hidden" name="data" id="data" value="">
                 <input type="hidden" name="hprem" id="hprem" value="0">

            </form>

            <script>
               var cropme = $('cropme');
               var cropt = $('croptop');
               var cropr = $('cropright');
               var cropl = $('cropleft');
               var cropb = $('cropbottom');
               var cnw = $('cnw');
               var cne = $('cne');
               var csw = $('csw');
               var cse = $('cse');
               var igw = $('hidw');
               var igh = $('hidh');
               var cot = $('cot');
               var cob = $('cob');
               var cor = $('cor');
               var col = $('col');
               
               var cropw = 0;
               var croph = 0;
               var freecrop = false;
               var cropAspect = 0;

               function setCropPos(x,y,w,h) {
                    cropme.style.top = y;
                    cropme.style.left = x;
                   
                    cposx=x;
                    cposy=y;
                    if (w != -1) {
                      cropw = Math.round(w);
                    }
                    if (h != -1) {
                      croph = Math.round(h);
                    }
                    $('fcx').value = x;
                    $('fcy').value = y;
                    $('fcw').value = cropw;
                    $('fch').value = croph;
                    sc(x,y,cropw,croph,cropme,0);
                    sc(x,y,cropw,croph,cropt,'t');
                    sc(x,y,cropw,croph,cropb,'b');
                    sc(x,y,cropw,croph,cropr,'r');
                    sc(x,y,cropw,croph,cropl,'l');
                    sc(x,y,cropw,croph,cnw,'nw');
                    sc(x,y,cropw,croph,cne,'ne');
                    sc(x,y,cropw,croph,csw,'sw');
                    sc(x,y,cropw,croph,cse,'se');
                    sc(x,y,cropw,croph,cot,'cot');
                    sc(x,y,cropw,croph,cob,'cob');
                    sc(x,y,cropw,croph,cor,'cor');
                    sc(x,y,cropw,croph,col,'col');
//document.getElementById('cropcoords').innerHTML = ' (' + parseInt(w) + ', ' + parseInt(h) + ')';
               }

               function sc(x,y,w,h,obj,p) {
                    thick = 3;
                    if (p != 0) {
                      if (p == 't') {
                        y = y - thick;
                        x = x;
                        w = w;
                        h = thick;
                      } else if (p == 'b') {
                        y = y + h;
                        x = x;
                        w = w;
                        h = thick;
                      } else if (p == 'r') {
                        y = y;
                        h = h;
                        x = x + w;
                        w = thick;      
                      } else if (p == 'l') {
                        y = y;
                        h = h;
                        x = x - thick;
                        w = thick;
                      } else if (p == 'nw') {
                        thick = 6;
                        y = y - thick;
                        x = x - thick;
                        w = thick;
                        h = thick;
                      } else if (p == 'ne') {
                        thick = 6;
                        y = y - thick;
                        x = x + w;
                        w = thick;
                        h = thick;
                      } else if (p == 'se') {
                        thick = 6;
                        y = y + h;
                        x = x + w;
                        w = thick;
                        h = thick;
                      } else if (p == 'sw') {
                        thick = 6;
                        y = y + h;
                        x = x - thick;
                        h = thick;
                        w = thick;
                      } else if (p == 'cot') {
                        h = y
                        y = 0;
                        x = 0;
                        w = igw.value;
                      } else if (p == 'cob') {
                        y = y + h;
                        h = igh.value - y;
                        w = igw.value;
                        x = 0;
                      } else if (p == 'cor') {
                        x = w + x;
                        y = y;
                        w = igw.value - x;
                        h = h;
                      } else if (p == 'col') {
                        w = x;
                        x = 0;
                        y = y;
                        h = h;
                      }
                    }
                    obj.style.top = y;
                    obj.style.left = x;
                    obj.style.width = w + "px";
                    obj.style.height = h + "px";
               }

               function showCrop() {
                    cropme.style.display = "block";
                    cropl.style.display = "block";
                    cropr.style.display = "block";
                    cropt.style.display = "block";
                    cropb.style.display = "block";
                    cnw.style.display = "block";
                    cne.style.display = "block";
                    csw.style.display = "block";
                    cse.style.display = "block";
                    cot.style.display = "block";
                    cor.style.display = "block";
                    col.style.display = "block";
                    cob.style.display = "block";
               }

               function hideCrop() {
                    cropme.style.display = "none";
                    cropt.style.display = "none";
                    cropr.style.display = "none";
                    cropl.style.display = "none";
                    cropb.style.display = "none";
                    cnw.style.display = "none";
                    cne.style.display = "none";
                    cse.style.display = "none";
                    csw.style.display = "none";
                    cot.style.display = "none";
                    cor.style.display = "none";
                    col.style.display = "none";
                    cob.style.display = "none";
               }

               function changeAspect() {
                    // text field changed.  
                    aw = $('aspectWidth');
                    ah = $('aspectHeight');
                    w = aw.value;
                    h = ah.value;
                    if (!isNumeric(w)) {
                      alert('You must enter a number');
                      aw.value="1";
                      return;
                    }
                    if (!isNumeric(h)) {
                      alert('You must enter a number');
                      aw.value="1";
                      return;
                    }
                    if (w == "" || h == "") {
                      return;
                    }
                    if (w <= 0 || h <= 0) {
                      alert('Sorry, but you must enter positive numbers');
                      return;
                    }
                    setCropType(w,h,false);
               }

               function setManualCrop() {
                    // radio button selected.
                    // enable text boxes.
                    // (remember to disable them otherwise)
                    // call changeAspect.
                    changeAspect(); 
                    $('aspectWidth').disabled = false;  
                    $('aspectHeight').disabled = false; 
               }
               
               function doCover() {
                cov = $('cover'); 
                    if (cov.checked) {
                      setCropType(851,315,true);
                      $('cnone').disabled = true;
                      $('ca').disabled = true;
                      $('cb').disabled = true;
                      $('cc').disabled = true;
                      $('cd').disabled = true;
                      $('h').disabled = true;
                      $('w').disabled = true;
                    } else {
                      setCropType(0,0,true);  
                      $('cnone').disabled = false;
                      $('ca').disabled = false;
                      $('cb').disabled = false;
                      $('cc').disabled = false;
                      $('cd').disabled = false;
                      $('h').disabled = false;
                      $('w').disabled = false;
                      $('cnone').checked = true;
                    }
               }
               
               function setCropType(x,y) {
                    setCropType(x,y,true);
               }
               
               function setCropType(x,y,dis) {  
                    $('aspectHeight').disabled = dis; 
                    $('aspectWidth').disabled = dis;  
                    if (x==0 && y==0) {
                      hideCrop();
                      $('fcon').value = "0";
document.getElementById('besideMouse').style.display = 'none';                        
                    } else if (x == -1 && y == -1) {  
document.getElementById('besideMouse').style.display = 'none';                      
                      $('fcon').value = "1";
                      freecrop = true;
                      w = igw.value * 0.5;
                      h = igw.value * 0.5;
                      setCropPos(0,0,w,h);
                      showCrop();
                    } else {
//document.getElementById('cropcoords').style.display = 'inline';                        
                      setCropPos(0,0,w,h);
                      $('fcon').value = "1";
                      freecrop = false;
                      iw = igw.value;
                      ih = igh.value;
                      cropAspect = x/y;
                      h = 0;
                      w = 0;
                      if (iw > ih) {
                        h = ih * 0.5;
                        w = h * cropAspect;
                      } else {
                        w = iw * 0.5;
                        h = w / cropAspect;
                      }
                      if (cposx < 0 || cposy < 0) {
                        cposx = iw*0.25;
                        cposy = ih*0.25;
                      }
                      if (cposx + w > iw) {
                        w = iw - cposx;
                        h = w / cropAspect;
                      }
                      if (cposy + h > ih) {
                        h = ih - cposy;
                        w = h * cropAspect;
                      }
                      setCropPos(cposx,cposy,w,h);
                      showCrop();
                    }
               }

               function isNumeric(sText) {
                    var ValidChars = "0123456789.";
                    var IsNumber=true;
                           var Char;
                    for (i = 0; i < sText.length && IsNumber == true; i++) { 
                      Char = sText.charAt(i); 
                      if (ValidChars.indexOf(Char) == -1) {
                        IsNumber = false;
                      }
                    }
                    return IsNumber;
                }

                   var mouseDown = false;
                   var mouseType = 0;
                   var lastx = -1;
                   var lasty = -1;
                   var cposx = -1;
                   var cposy = -1;
                   cropme.style.left = 0;
                   
                function rc(s) {
                    mouseDown = true;
                    mouseType = s;
               }
               
               function cropMouseDown(event) {
                    mouseDown = true;
                    mouseType = "m";
               }

               function cropMouseUp() {
                    mouseDown = false;
                    lastx=-1;
                    lasty=-1;
               }

               Event.observe($('tempimage'), 'load', function(event) {
                    document.body.style.cursor = 'default';
                    $('loading').style.visibility = "hidden";
               });
               
               Event.observe(document, 'mousedown', function(e) {
                    prevent(e);
               });
               
               function prevent(e) {
                       var targ;
                       if (!e) var e = window.event;
                       if (e.target) targ = e.target;
                       else if (e.srcElement) targ = e.srcElement;
                       if (targ.nodeType == 3) // defeat Safari bug
                               targ = targ.parentNode;
                       if (targ.id=="tempimage") {
                               e.preventDefault ? e.preventDefault() : e.returnValue = false;
                       }
               
               }
               
               Event.observe(document, 'mouseup', function(e) {
                    cropMouseUp();
// document.getElementById('besideMouse').style.display = 'none';
               });
               Event.observe(document, 'mousemove', function(event) {
                    //$('msg').innerHTML = x + ", " + y + "(" + mouseDown + ")";
                    if (mouseDown) {
                      x = Event.pointerX(event);
                      y = Event.pointerY(event);
            
                      if (lastx == -1) {
                        lastx = x;
                        lasty = y;
                      } else {
                        dx = x - lastx;
                        dy = y - lasty;
                        //curx = cropme.style.left;
                        //cury = cropme.style.top;
                        if (mouseType == "m") {
                          nx = cposx + dx;
                          ny = cposy + dy;
                          cposx = nx;
                          cposy = ny;
                          if (cposx < 0) {
                            cposx = 0;
                          }
                          if (cposy < 0) {
                            cposy = 0;
                          }
                          if (cposx + cropw > igw.value) {
                            cposx = igw.value - cropw;
                          }
                          if (cposy + croph > igh.value) {
                            cposy = igh.value - croph;
                          }
                          setCropPos(cposx,cposy,-1,-1);
                   
                          //$('msg').innerHTML = x + ", " + y + "(LAST: " + lastx + ", " + lasty + ") (DEL: " + dx + ", " + dy + ") (CUR:" + curx + ", " + cury + ") (nx: " + nx + ", " + ny + ")"  + " (" + mouseDown + ")";
                          lastx = x;
                          lasty = y;
                        } else {
                          oldx = cposx;
                          oldy = cposy;
                          oldw = cropw;
                          oldh = croph;
                          newx = 0;
                          newy = 0;
                          neww = 0;
                          newh = 0;
                          if (mouseType == "n") {
                            // keep width the same.  increase height. decrease y down to 0.  increase y up to oldy+h-1
                            neww = oldw;
                            newx = oldx;
                            newy = oldy + dy;
                            newh = oldh - dy;
                            //check boundaries
                            if (newy > oldy + oldh - 2) {
                              newy = oldy;
                              newh = oldh;
                            }
                            if (newy < 0) {
                              newy = oldy;
                              newh = oldh;
                            }
                            if (newy + newh > igh.value) {
                              newy = oldy;
                              newh = oldh;
                            }
                            
                            if (!freecrop) {
                              // handle this.
                              neww = cropAspect * newh;
                              newx = oldx;
                   
                              // check boundaries
                              if (newx + neww > igw.value) {
                                newy = oldy;
                                newx = oldx;
                                neww = oldw;
                                newh = oldh;
                              }
                            }
                            
                          } else if (mouseType == "s") {
                            neww = oldw;
                            newx = oldx;
                            newy = oldy;
                            newh = oldh + dy;
                   
                            if (newy + newh > igh.value) {
                              newy = oldy;
                              newh = oldh;
                            }
                            if (newh < 2) {
                              newy = oldy;
                              newh = oldh;
                            }
                   
                   
                            if (!freecrop) {
                              neww = cropAspect * newh;
                              newx = oldx;
                              if (newx + neww > igw.value) {
                                newy = oldy;
                                newx = oldx;
                                neww = oldw;
                                newh = oldh;
                              }
                            }
                          } else if (mouseType == "e") {
                            newx = oldx;
                            newy = oldy;
                            newh = oldh;
                            neww = oldw + dx;
                            
                            if (newx + neww > igw.value) {
                              neww = oldw;
                            }
                            if (neww < 2) {
                              neww = oldw;
                            }
                            
                            if (!freecrop) {
                              newh = neww / cropAspect;
                              if (newy + newh > igh.value) {
                                newy = oldy;
                                newh = oldh;
                                newx = oldx;
                                neww = oldw;
                              }
                            }
                          } else if (mouseType == "w") {
                            newx = oldx + dx;
                            newy = oldy;
                            newh = oldh;
                            neww = oldw - dx;
                            if (newx < 0) {
                              newx = oldx;
                              neww = oldw;
                            }
                            if (newx > oldx + oldw - 2) {
                              newx = oldx;
                              neww = oldw;
                            }
                            if (!freecrop) {
                              newh = neww / cropAspect;
                              if (newy + newh > igh.value) {
                                newy = oldy;
                                newh = oldh;
                                newx = oldx;
                                neww = oldw;
                              }
                            }
                          } else if (mouseType == "ne") {
                            newx = oldx;
                            neww = oldw + dx;
                            newy = oldy + dy;
                            newh = oldh - dy;
                            if (newy < 0) {
                              newy = oldy;
                              newh = oldh;
                            }
                            if (neww < 2) {
                              neww = oldw;
                            }
                            if (newx + neww > igw.value) {
                              newx = oldx;
                              neww = oldw;
                            }
                            if (newh < 2) {
                              newh = oldh;
                              newy = oldy;
                            }
                            if (!freecrop) {
                              if (Math.abs(dx) > Math.abs(dy)) {
                                neww = oldw + dx;
                                newh = Math.round(neww / cropAspect);
                                newy = oldy + oldh - newh;
                              } else {
                                newh = oldh - dy;
                                neww = Math.round(newh * cropAspect);
                                newy = oldy + oldh - newh;
                              }
                              if (newy < 0 || newx + neww > igw.value || neww < 2 || newh < 2) {
                                newy = oldy;
                                newh = oldh;
                                newx = oldx;
                                neww = oldw;
                              }
                            }
                          } else if (mouseType == "nw") { 
                            newx = oldx + dx;
                            neww = oldw - dx;
                            newy = oldy + dy;
                            newh = oldh - dy;
                            if (!freecrop) {
                              if (Math.abs(dx) > Math.abs(dy)) {
                                newx = oldx + dx;
                                neww = oldw - dx;
                                newh = Math.round(neww / cropAspect);
                                newy = oldy + oldh - newh;
                              } else {
                                newy = oldy + dy;
                                newh = oldh - dy;
                                neww = Math.round(newh * cropAspect);
                                newx = oldx + oldw - neww;
                              }
                            }
                            if (newy < 0 || newx < 0 || neww < 2 || newh < 2) {
                              newy = oldy;
                              newh = oldh;
                              newx = oldx;
                              neww = oldw;
                            }
                   
                          } else if (mouseType == "se") {
                            newy = oldy;
                            newx = oldx;
                            neww = oldw + dx;
                            newh = oldh + dy;
                   
                            if (!freecrop) {
                              if (Math.abs(dx) > Math.abs(dy)) {
                                newh = Math.round(neww / cropAspect);
                              } else {
                                neww = Math.round(newh * cropAspect);
                              }
                            }
                            
                            if (neww < 2 || newh < 2 || newx+neww > igw.value || newy+newh > igh.value) {
                              neww = oldw;
                              newh = oldh;
                            }
                          } else if (mouseType == "sw") {
                            newy = oldy;
                            newx = oldx + dx;
                            neww = oldw - dx;
                            newh = oldh + dy;
                   
                            if (!freecrop) {
                              if (Math.abs(dx) > Math.abs(dy)) {
                                newh = Math.round(neww / cropAspect);
                                
                              } else {
                                neww = Math.round(newh * cropAspect);
                                newx = oldx + oldw - neww;
                              }
                            }
                   
                   
                            if (newh < 2 || neww < 2 || newx < 0 || newy + newh > igh.value) {
                              newy = oldy;
                              newh = oldh;
                              neww = oldw;
                              newx = oldx;
                            }
                          }
                          setCropPos(newx,newy,neww,newh);

document.getElementById('besideMouse').style.left = event.pageX + 10 + 'px';
document.getElementById('besideMouse').style.top = event.pageY + 10 + 'px';
document.getElementById('besideMouse').style.display = 'inline';                        
document.getElementById('besideMouse').innerHTML = 'Crop ' + neww + ' x '+ newh;

                          lastx  = x;
                          lasty = y;
                        }
                      }
                    }
               });
               


                              
               function snap(v) {
                  snapped = 0;
                  nv = doSnap(v, 150, 20);
                  if (nv == v) {
                    nv = doSnap(v, 300, 20);
                  }
                  if (nv == v) {
                    nv = doSnap(v, 600, 20);
                  }
                  if (nv == v) {
                    nv = doSnap(v, 800, 20);
                  }
                  if (nv == v) {
                    nv = doSnap(v, 1000, 20);
                  }
                  if (nv == v) {
                    nv = doSnap(v, 1200, 20);
                  }
                  return nv;
               }
               function doSnap(v,size,toler) {
                  var aspect = <?php echo $aspect_ratio;?>;
                  setwidth = 0;
                  diff = Math.abs(size-v);
                  if (diff < toler) {
                    v = size;
                setwidth = 1;
                  }
                  height = v*aspect;
                  
                  if (setwidth == 0) {
                   diff = Math.abs(size-height);
                   if (diff < toler) {    
                      height = size;
                  v = height / aspect;
                   }
                  }
                  return v;
               }
               
               function setWidth(v) {
                  var aspect = <?php echo $aspect_ratio;?>;
                  var scaleme = $("scaleme");
                  
                  scaleme.style.width = v+"px";
               
                  height = v*aspect;
                  width = v;
                  
                  var h = $('h');
                  var w = $('w');
                  var msg = $('msg');
                  
                  oldw = igw.value;
                  oldh = igh.value;
                  
                  
                  igw.value=Math.round(width);
                  igh.value=Math.round(height);
                  w.value = Math.round(width);
                  h.value = Math.round(height);
               
                  wmult = width / oldw;
                  hmult = height / oldh;
               
                  setCropPos(cposx*wmult, cposy*hmult, cropw*wmult, croph*hmult);
               
                  if (igw.value > 2000) {
                       msg.innerHTML = "<br/>Note: Use the scrollbar at the bottom to see the whole image.";
                  } else {
                       msg.innerHTML = "";
                  }
               }
               
               function scaleIt(v,sn) {
                  var npixels = 0.7828125;
                  max = 2000;
                  floorSize = .03;
                  ceilingSize = 1.0;
                  
                  exponent = 4 + (v * 3.60090246);
                  v = Math.pow(2.718281828,exponent);
                  if (sn == 1) {
                    v = snap(v);
                  }

                  setWidth(v);
               }
               
               <?php $max_scale = 1200; ?>
               <?php if($width > $max_scale) { ?>
                    scaleto = <?php echo ($max_scale / ($width+55));?>;
               <?php }
               else { ?>
                    scaleto = <?php echo (($width+55) / $max_scale);?>;
               <?php } ?>

               function resetValues() {
                var h = $('h');
                var w = $('w');
                var hidw = $('hidw');
                var hidh = $('hidh');
                w.value = hidw.value;
                h.value = hidh.value;
               }
               function changeHeight() {
                    var aspect = <?php echo $aspect_ratio;?>;
                var h = $('h');
                var w = $('w');
                if (h.value=="") {
                  return;
                }
                if (isNumeric(h.value)) {
                  h.value = Math.round(h.value);
                  if (h.value > 2000) {
                    alert('Sorry, but the max value is 2000 pixels');
                    resetValues();
                    return;
                  }
                  w.value = Math.round(h.value / aspect);   
                        var hidw = $('hidw');
                        var hidh = $('hidh');
                  hidw.value=w.value;
                  hidh.value=h.value;
                      var scaleme = $("scaleme");
                  scaleme.style.width = w.value+"px";
                } else {
                  alert('Sorry, but you must enter a number.');
                  resetValues();
                  return;
                }
               }
               function changeWidth() {
                    var aspect = <?php echo $aspect_ratio;?>;
                var h = $('h');
                var w = $('w');
                if (w.value=="") {
                  return;
                }
                if (isNumeric(w.value)) {
                  w.value = Math.round(w.value);
                  if (w.value > 2000) {
                    alert('Sorry, but the max value is 2000 pixels');
                    resetValues();
                    return;
                  }
                  h.value = Math.round(w.value * aspect);
                  oldw = igw.value;
                  oldh = igh.value;
                  igw.value=w.value;
                  igh.value=h.value;
                      var scaleme = $("scaleme");
                  scaleme.style.width = w.value+"px";
               
                  wmult = w.value / oldw;
                  hmult = h.value / oldh;
                //  alert("setting crop pos " + wmult + " " + hmult);
                  setCropPos(cposx*wmult, cposy*hmult, cropw*wmult, croph*hmult);
                       
                } else {
                  alert('Sorry, but you must enter a number.');
                  resetValues();
                  return;
                }
               }
/*
               function blackandwhite() {
                grv = $('grv').value;
                if (grv == 0) {
                  grv = 1;
                  addAction(1,"");
                } else if (grv == 1) {
                  grv = 0;
                  removeAction(1);
                }
                $('grv').value=grv;
                updatePreview();
               }
               function mirrorIt() {
                mirrorv = $('mirrorv').value;
                if (mirrorv == 0) {
                  mirrorv = 1;
                  addAction(12,"");
                } else if (mirrorv == 1) {
                  mirrorv = 0;
                  removeAction(12);
                }
                $('mirrorv').value=mirrorv;
                updatePreview();
               }

               function sepiatone() {
                sepv = $('sepv').value;
                       if (sepv == 0) {
                               sepv = 1;
                               addAction(7,"");
                       } else if (sepv == 1) {
                               sepv = 0;
                               removeAction(7);
                       }
                       $('sepv').value=sepv;
                       updatePreview();
                                          
               }
               
               
               function doAutolevels() {
                hprem = $('hprem').value;
                if (hprem == 0) {
                  alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                  return false;
                } 
                hautolevel = $('hautolevel').value;
                if (hautolevel == 0) {
                  hautolevel = 1;
                  addAction(3,"");
                } else if (hautolevel == 1) {
                  hautolevel = 0;
                  removeAction(3);
                }
                $('hautolevel').value=hautolevel;
                updatePreview();
               }
               
               function doAutowhite() {
                hprem = $('hprem').value;
                if (hprem == 0) {
                  alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                  return false;
                }
                       hautowhite = $('hautowhite').value;
                       if (hautowhite == 0) {
                               hautowhite = 1;
                               addAction(9,"");
                       } else if (hautowhite == 1) {
                               hautowhite = 0;
                               removeAction(9);
                       }
                       $('hautowhite').value=hautowhite;
                       updatePreview();
               }
               
               function doiso() {
                hprem = $('hprem').value;
                if (hprem==0) { 
                  alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                  return false;
                }
                       hiso = $('hiso').value;
                       if (hiso == 0) {
                               hiso = 1;
                               addAction(11,"");
                       } else if (hiso == 1) {
                               hiso = 0;
                               removeAction(11);
                       }
                       $('hiso').value=hiso;
                       updatePreview();
               }
               function doKnox() {
                       hprem = $('hprem').value;
                       if (hprem==0) {
                               //alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                               //return false;
                       }
                       hknox = $('hknox').value;
                       if (hknox == 0) {
                               hknox = 1;
                               addAction(15,"");
                       } else if (hknox == 1) {
                               hknox = 0;
                               removeAction(15);
                       }
                       $('hknox').value=hknox;
                       updatePreview();
               }
               
               function doLomoYellow() {
                       hprem = $('hprem').value;
                       if (hprem==0) {
                               //alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                               //return false;
                       }
                       hlomoy = $('hlomoy').value;
                       if (hlomoy == 0) {
                               hlomoy = 1;
                               addAction(19,"");
                       } else if (hlomoy == 1) {
                               hlomoy = 0;
                               removeAction(19);
                       }
                       $('hlomoy').value=hlomoy;
                       updatePreview();
               }
               function doLomo() {
                hprem = $('hprem').value;
                       if (hprem==0) {
                               //alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                               //return false;
                       }
                       hlomo = $('hlomo').value;
                       if (hlomo == 0) {
                               hlomo = 1;
                               addAction(13,"");
                       } else if (hlomo == 1) {
                               hlomo = 0;
                               removeAction(13);
                       }
                       $('hlomo').value=hlomo;
                       updatePreview();
               }
               
               function doStove() {
                       hprem = $('hprem').value;
                       if (hprem==0) {
                               //alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                               //return false;
                       }
                       hstove = $('hstove').value;
                       if (hstove == 0) {
                               hstove = 1;
                               addAction(18,"");
                       } else if (hstove == 1) {
                               hstove = 0;
                               removeAction(18);
                       }
                       $('hstove').value=hstove;
                       updatePreview();
               }
               
               
               function doVig() {
                       hprem = $('hprem').value;
                       if (hprem==0) {
                               //alert("This feature is only available to Resizr Premium users.  To see how this feature works, please take a look at our DEMO.");
                               //return false;
                       }
                       hvig = $('hvig').value;
                       if (hvig == 0) {
                               hvig = 1;
                               addAction(14,"");
                       } else if (hvig == 1) {
                               hvig = 0;
                               removeAction(14);
                       }
                       $('hvig').value=hvig;
                       updatePreview();
               }
               
               
               function doLevel() {
                black = $('black');
                white = $('white');
                gamma = $('gamma');
                saturation = $('saturation');
                removeAction(6);
                data = black.value + "," + white.value + "," + gamma.value + "," + saturation.value;
                addAction(6,data);
                updatePreview();
               }
               
               function displayHistogram() {
                h = $('histogramspan');
                chk = $('histogram').checked;
                if (chk) {
                  Effect.Appear(h, { duration: 0.7 });
                } else {
                  Effect.Fade(h, { duration: 0.7 });
                }
               }
               
               function changebrightness() {
                removeAction(2);
                addAction(2,$('bselect').value);
                updatePreview();
               }
               function changecontrast() {
                removeAction(8);
                addAction(8,$('cselect').value);
                updatePreview();
               }
               function changesaturation() {
                       removeAction(10);
                       addAction(10,$('sselect').value);
                       updatePreview();
               }
*/               
               
               
               
               function addAction(action,data) {
                actions = $('actions').value;
                datas = $('data').value;
                
                actions = actions + ";" + action;
                datas = datas + ";" + data;
               
                $('actions').value = actions;
                $('data').value = datas;
               }
               
               function removeAction(action) {
                actions = $('actions').value; 
                datas = $('data').value;
               
                aar = actions.split(";");
                dar = datas.split(";");
                k = 0;
                actions = "";
                datas = "";
                while (k < aar.length) {
                  if (aar[k] != action && aar[k] != "") {
                    actions = actions + ";" + aar[k];
                    datas = datas + ";" + dar[k];
                  }
                  k++;
                }
                $('actions').value = actions;
                $('data').value = datas;
               }
               
               function updatePreview() {
                actions = $('actions').value;
                datas = $('data').value;
                base = "ti.php?fn=bf86e5feb23b35ff6b66e4348dca8851.jpg";
                ti = $('tempimage');
                ti.src = base + "&actions=" + actions + "&data=" + datas;
                //new Effect.Fade(ti);
                document.body.style.cursor = 'wait';
                $('loading').style.visibility = "visible";
               
               }
               
               var demoSlider = new Control.Slider('handle1','track1', {axis: 'horizontal', minimum: 0, maximum:790, alignX: 0, increment: 2, sliderValue: scaleto} );
               var histoSlider = new Control.Slider(new Array('hhandle1','hhandle2','hhandle3'),'htrack', {axis: 'horizontal', minimum: 0, maximum:100, alignX: 0, increment: 1, sliderValue: [0,0.5,1.0] } );
               
               var lastL = 0;
               var lastC = 0.5;
               var lastR = 1.0;
               var lastG = 1.0;
               
               histoSlider.options.onSlide = function(value) {
                
                histoSliderCheck(value);
               }
               function getNewMidpoint(l,r) {
                g = inverseGamma(l,r);
                return g;
               }
               
               function getGamma(l,r,c) {
                range = r-l;
                offsetC = c-l;
                //gamma goes from 0.3 to 1.7: gamma range = 1.4
                pct = offsetC / range;
                return (pct * 1.4) + 0.3;
               }
               
               function inverseGamma(l,r) {
                range = r-l;
                lastPct = (lastG - 0.3) / 1.4;
                return l + (range * lastPct);
               }
               
               function histoSliderCheck(value) {
                l = value[0];
                c = value[1];
                r = value[2];
                if (l != lastL) {
                  if (l > r-.06) {
                    histoSlider.setValue(lastL);
                    l = lastL
                  }
                  histoSlider.setValue(getNewMidpoint(l,r), 1);
                  
                } else if (r != lastR) {
                  if (r < l+.06) {  
                    histoSlider.setValue(lastR);
                    r = lastR;
                  }
                  histoSlider.setValue(getNewMidpoint(l,r), 1);
                } else {
                  if (c < l+.03 || c > r-.03) {
                    histoSlider.setValue(lastC);
                    c = lastC;
                  }
                  gamma = getGamma(l,r,c);
                  lastG = gamma;
                }
                lastL = l;
                lastR = r;
                lastC = c;
               }
               histoSlider.options.onChange = function(value) {
                histoSliderCheck(value);
                l = (lastL * 100).toFixed();
                r = (lastR * 100).toFixed();
                range = lastR-lastL;
                offsetC = lastC-lastL;
                pct = offsetC / range;
                       removeAction(6);
                       data = l + "," + r + "," + lastG;
                       addAction(6,data);
                       updatePreview();
                      
               }
               
               demoSlider.options.onSlide = function(value){
                 scaleIt(value,1);
               }
               
               demoSlider.options.onChange = function(value){
                 scaleIt(value,1);
               }

              function drag_div(div_id){
                  var div;

                  div = document.getElementById(div_id);

                  div.addEventListener('mousedown', function(e) {
                      div.isDown = true;
                      div.offset = [
                          div.offsetLeft - e.clientX,
                          div.offsetTop - e.clientY
                      ];
                  }, true);

                  div.addEventListener('mouseup', function() {
                      div.isDown = false;
                  }, true);

                  div.addEventListener('mousemove', function(event) {
                      event.preventDefault();
                      if (div.isDown) {
                          div.mousePosition = {

                              x : event.clientX,
                              y : event.clientY

                          };
                          div.style.left = (div.mousePosition.x + div.offset[0]) + 'px';
                          div.style.top  = (div.mousePosition.y + div.offset[1]) + 'px';
                      }
                  }, true);
              }

               drag_div('toolbar');
               
               scaleIt(scaleto,0);
               init();

               //new Tip($('saveasid'),'aaa');
            </script>
         </div>
      </div>
      <!-- end container -->
      <br class="cl">

   </body>
</html>
