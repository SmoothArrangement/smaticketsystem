<?php
     session_start();
     include 'header.php';
     include 'connection.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     if(!isset($_SESSION['utype']) || $_SESSION['utype'] != "1") {
          if($_SESSION['utype'] != "3") {
               echo "<script type='text/javascript'>window.top.location='account.php';</script>";
          }
     }
     if(isset($_REQUEST['send'])) {
          $subject = $_REQUEST['betreff'];
          $text = mysql_real_escape_string($_REQUEST['emailtext']);
          $text = str_replace('/n', '', str_replace('/r', '', $text));
          $sender = $_REQUEST['emailadresse'];
          $tid = $_REQUEST['tid'];
          if($subject != "" && $text != "" && $sender != "" && $tid != ""){
               $subject = mysql_real_escape_string($subject);
               $text = mysql_real_escape_string($text);
               $sender = mysql_real_escape_string($sender);
               $upquery = "UPDATE email_template SET vSubject='".$subject."',tMessage='".$text."',vSender='".$sender."' WHERE iId='".$tid."'";
               mysql_query($upquery);
               $_SESSION['sucess'] = "Die E-Mail Vorlage wurde erfolgreich geändert.";
               echo "<script type='text/javascript'>window.top.location='settings.php';</script>";
          }
     }
     $select = "SELECT * FROM email_template";
     $result = mysql_query($select);
?>
<!-- End of header -->
    <!-- The container of the sidebar and content box -->
    <div role="main" id="main" class="container_12 clearfix">
    
        <!-- The blue toolbar stripe -->
        <section class="toolbar">
            <div class="userMsg">
               Du bist eingeloggt <?=$_SESSION['uname']?>
            </div><!-- End of .buttons -->    
            <!-- <input type="search" data-source="extras/search.php" placeholder="Suche..." autocomplete="off" class="tooltip" title="e.g. Peach" data-gravity=s> -->
        </section><!-- End of .toolbar-->
        
        <!-- The sidebar -->
        <?php
               include 'sidebar.php';     
        ?>
        <!-- End of sidebar -->

        <!-- Here goes the content. -->
        <section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">E-Mail Einstellungen</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>Benachrichtigungs Einstellungen</h2>
					</div>
					
					<div class="content">
					
						<table class="dynamic styled" data-show-Filter-Bar="false">
							<thead>
                                        <tr>
                                             <th>E-Mail Vorlage</th>
                                             <th>Absender Adresse</th>
                                             <th>Aktion</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                             while($row = mysql_fetch_assoc($result)){
                                        ?>
                                             <tr>
                                                  <td><?=$row['vTemplate']?></td>
                                                  <td><?=$row['vSender']?></td>
                                                  <td><a href="#"><span class="icon tedit" id="<?=$row['iId']?>"><center><img src="img/icons/packs/fugue/16x16/pencil.png" alt="E-Mail Vorlage bearbeiten" title="E-Mail Vorlage bearbeiten" height=16 width=16></center></span></a></td>
                                             </tr>
                                        <?php
                                             }
                                        ?>
							</tbody>
						</table>
									<div id="Legende" style="float:right;">
									<p><b>Legende:</b></p>
									<p>
									<span class="icon"><img src="img/icons/packs/fugue/16x16/pencil.png" alt="E-Mail Vorlage bearbeiten" title="E-Mail Vorlage bearbeiten" height=16 width=16></span> = bearbeiten&nbsp;
									</p>
									</div>						
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
			
        </section><!-- End of #content -->
        
    </div><!-- End of #main -->
    <div style="display: none;" id="dialog_edit_tamplete" title="Vorlage bearbeiten">
          <form action="" class="full validate" method="post">
               <fieldset>
                    <div class="row">
            			<label for="emailvorlage">
            				<strong>E-Mail Vorlage</strong>
            			</label>
            			<div>
            				<input type="text" disabled placeholder="CONTENT FROM DB" name="emailvorlage" id="emailvorlage" />
            			</div>
            		</div>
            		<input type="hidden" name="tid" id="tid" value="" />
                    <div class="row">
                         <label for="betreff">
                              <strong>E-Mail Betreff</strong>
                         </label>
                         <div>
                              <input type="text" required placeholder="CONTENT FROM DB (subject) but changable" name="betreff" id="betreff" />
                         </div>
                    </div>					
                	<div class="row not-on-phone">
                		<label for="emailtext">
                			<strong>E-Mail Text</strong>
                			<small>Variablen sind erlaubt.</small>
                		</label>
                		<div>
                			<textarea required class="editor" name="emailtext" id="emailtext"></textarea>
                		</div>
                	</div>
                	<div class="row">
                		<label for="emailadresse">
                			<strong>Absener Adresse</strong>
                		</label>
                		<div>
                			<input placeholder="CONTENT FROM DB (from) but changable" required type="email" name="emailadresse" id="emailadresse" />
                		</div>
                	</div>		
                    <div class="actions">
                         <div class="left">
                              <button class="grey cancel">abbrechen</button>
                         </div>
                         <div class="right">
                              <input type="submit" value="Speichern" name=send />
                         </div>
                    </div><!-- End of .actions -->
               </fieldset><!-- End of fieldset -->			
          </form>
    </div>
    <script>
		$$.ready(function() {
              $( "#dialog_edit_tamplete" ).dialog({
                  autoOpen: false,
                  modal: true,
                  width: 1100,
                  open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
              }).find('button.submit').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  if ($el.validate().form()) {
                      $el.find('form')[0].reset();
                      $el.dialog('close');
                  }
              }).end().find('button.cancel').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  $el.find('form')[0].reset();
                  $el.dialog('close');;
              });
              $( ".tedit" ).live("click",function() {
                  var id = $(this).attr('id');
                  $.post( "settings_edit.php", { tid: id }).done(function( data ) {
                         var obj = jQuery.parseJSON(data);
                         var iId = obj.iId;
                         var vTemplate = obj.vTemplate;
                         var vSubject = obj.vSubject;
                         var tMessage = obj.tMessage;
                         var vSender = obj.vSender;
                         $("#tid").val(iId);
                         $("#emailvorlage").val(vTemplate);
                         $("#betreff").val(vSubject);
                         $("#emailtext").val(tMessage);
                         $("#emailtext").css("width","923px");
                         $(".cleditorMain").children("iframe").css("width","923px");
                         $('#emailtext').cleditor()[0].refresh();
                         $("#emailadresse").val(vSender);
                         //$( "#dialog_edit_tamplete" ).html(data);
                         $("#dialog_edit_tamplete").dialog( "open" );
                  });
                  return false;
              });
          });
    </script>
    <!-- The footer -->
    <?php
          include 'foooter.php';     
    ?>