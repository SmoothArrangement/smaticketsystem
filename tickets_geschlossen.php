<?php
     session_start();
     include 'connection.php';
     include 'header.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $select = "SELECT tm.*,um1.vFname as sendfname,um1.vLname as sendlname,um2.vFname as recfname,um2.vLname as reclname FROM ticket_mst tm
               LEFT JOIN user_mst um1 ON tm.iSenderId=um1.iId
               LEFT JOIN user_mst um2 ON tm.iReceiverId=um2.iId  WHERE tm.iReceiverId='".$_SESSION['uid']."' OR tm.iSenderId='".$_SESSION['uid']."' ORDER BY tCreateDate DESC";
     $result = mysql_query($select);
     $new = 0;
     $close = 0;
     $open = 0;
     $overdue = 0;
     $data = array();
     while($row = mysql_fetch_assoc($result)){
          $data[] = $row;
          if($row['vStatus'] == "Open"){
               $open++;
          }
          if($row['vStatus'] == "Close"){
               $close++;
          }
          $date = date("Y-m-d");
          if($row['vView'] == "NO"){
               $new++;
          }
          if($row['dDate'] != "0000-00-00"){
               $date1 = date("Y-m-d",strtotime($row['dDate']));
               if($date > $date1 && $row['vStatus'] != "Close"){
                    $overdue++;
               }
          }     
     }
     //echo "<pre>";
     //print_r($data);exit;
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
					<ul class="stats">
				<li>
                    <strong><?=$new?></strong>
                    <small>Neue Tickets</small>
               </li>
               <li>
                    <strong><?=$open?></strong>
                    <small>Offene Tickets</small>
               </li>
               <li>
                    <strong><?=$close?></strong>
                    <small>Geschlossene Tickets</small>
               </li>
               <li>
                    <strong><?=$overdue?></strong>
                    <small>Überfällige Tickets</small>
               </li>
			</ul><!-- End of ul.stats -->

        <!-- Here goes the content. -->
<h1 class="grid_12 margin-top no-margin-top-phone">Geschlossene Tickets</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>Geschlossene Tickets</h2>
					</div>
					
					<div class="content">
					
						<div class="tabletools">
							<div class="left">
								<a href="tickets_neu.html"><i class="icon-plus"></i>Neues Ticket</a>
							</div>
							<div class="right"></div>
						</div>
						<table class="dynamic styled with-prev-next" data-show-Filter-Bar="true" data-table-tools='{"display":false}'>
							<thead>
								<tr>
									<th>Er&ouml;ffnet </th>
									<th>Zuletzt bearbeitet </th>
									<th>Beschreibung</th>
									<th>Ticket von</th>
									<th>Ticket an</th>
									<th>Priorit&auml;t</th>
									<th>Ticket Status</th>
									<th>Aktion</th>
								</tr>
							</thead>
							<tbody>
								<?php
                                             for($i=0; $i < count($data); $i++){
                                                  $priority = "Undefine";
                                                  if($data[$i]['vPriority'] == "Low"){
                                                       $priority = "Niedrig";
                                                  } else if($data[$i]['vPriority'] == "Normal"){
                                                       $priority = "Normal";
                                                  } else if($data[$i]['vPriority'] == "High"){
                                                       $priority = "Hoch";
                                                  } else if($data[$i]['vPriority'] == "Emeregncy"){
                                                       $priority = "Notfall";
                                                  }
                                                  $status = "Undefine";
                                                  if($data[$i]['vStatus'] == "Open"){
                                                       $status = "Offen";
                                                  } else if($data[$i]['vStatus'] == "Close"){
                                                       $status = "Geschlossen";
                                                  }
                                                  if($data[$i]['vStatus'] == "Close"){
                                      ?>
          								<tr>
          									<td><?=date("d.m.Y",strtotime($data[$i]['tCreateDate']))?></td>
          									<td><?=date("d.m.Y",strtotime($data[$i]['dEditDate']))?></td>
          									<td><?=$data[$i]['vSubject']?></td>
          									<td><?=$data[$i]['sendfname']." ".$data[$i]['sendlname']?></td>
          									<td><?=$data[$i]['recfname']." ".$data[$i]['reclname']?></td>
          									<td class="center"><?=$priority?></td>
          									<td class="center"><?=$status?></td>
          									<td class="center">
          									      <a href="tickets_view.php"><span class="icon tview" id="<?=$data[$i]['iId']?>"><img src="img/icons/packs/fugue/16x16/eye.png" alt="Ticket ansehen" title="Ticket ansehen" height=16 width=16></span></a>&nbsp;
          									</td>
          								</tr>
					             <?php
					                         }
                                             }
                                      ?>								
							</tbody>
						</table>
									<div id="Legende" style="float:right;">
									<p><b>Legende:</b></p>
									<p>
									<span class="icon"><img src="img/icons/packs/fugue/16x16/eye.png" alt="Ticket ansehen" title="Ticket ansehen" height=16 width=16></span> = Ticket ansehen&nbsp;
									</p>
									</div>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->

        </section><!-- End of #content -->

			
			
			
        </section><!-- End of #content -->
        
    </div><!-- End of #main -->
    <div style="display: none;" id="dialog_view_ticket" title="Ticket ansehen"></div>
    <script>
		$$.ready(function() {
              $( "#dialog_view_ticket" ).dialog({
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
              
              $( ".tview" ).live("click",function() {
                  var id = $(this).attr('id');
                  $.post( "tickets_view.php", { tid: id }).done(function( data ) {
                         $( "#dialog_view_ticket" ).html(data);
                         $( "#dialog_view_ticket" ).dialog( "open" );
                  });
                  return false;
              });
          });
    </script>
    <!-- The footer -->
    <?php
          include 'foooter.php';     
    ?>