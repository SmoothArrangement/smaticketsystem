<?php
     $self = $_SERVER['PHP_SELF'];
     //echo "<pre>";
     //print_r($_SERVER);exit;
     $first = "";
     $second = "";
     $third = "";
     $second1 = "";
     $third1 = "";
     $secondone = "";
     $secondtwo = "";
     $secondthree = "";
     $thirdone = "";
     $thirdtwo = "";
     $thirdthree = "";
     if($self == "/ticketsystem/tickets_neu.php"){
          $first = "current";
     }
     if($self == "/ticketsystem/tickets_alle.php" || $self == "/ticketsystem/tickets_offen.php" || $self == "/ticketsystem/tickets_geschlossen.php"){
          $second = "current";
          $second1 = "with_sub open";
          if($self == "/ticketsystem/tickets_alle.php"){
                $secondone = "current";
          }
          if($self == "/ticketsystem/tickets_offen.php"){
                $secondtwo = "current";
          }
          if($self == "/ticketsystem/tickets_geschlossen.php"){
                $secondthree = "current";
          }
     }
     if($self == "/ticketsystem/account.php" || $self == "/ticketsystem/user.php" || $self == "/ticketsystem/settings.php"){
          $third = "current";
          $third1 = "with_sub open";
          if($self == "/ticketsystem/account.php"){
                $thirdone = "current";
          }
          if($self == "/ticketsystem/user.php"){
                $thirdtwo = "current";
          }
          if($self == "/ticketsystem/settings.php"){
                $thirdthree = "current";
          }
     }
?>
<aside>
     <div class="top">
     <!-- Navigation -->
          <nav>
               <ul class="collapsible accordion">
                    <li class="<?=$first?>">
                         <a href="tickets_neu.php"><img src="img/icons/packs/fugue/16x16/plus.png" alt="" height=16 width=16>Neues Ticket</a>
                    </li> 
                    <li class="<?=$second?>">
                        <a href="javascript:void(0);" class="<?=$second1?>"><img src="img/icons/packs/fugue/16x16/notebook.png" alt="" height=16 width=16>Tickets</a>
                        <ul>
                              <?php
                                   if($_SESSION['utype'] == "1" || $_SESSION['utype'] == "3"){     
                              ?>
                                   <li class="<?=$secondone?>"><a href="tickets_alle.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/applications-stack.png" alt="" height=16 width=16></span>Alle</a></li>
                              <?php
                                   }   
                              ?>
                            <li class="<?=$secondtwo?>"><a href="tickets_offen.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/mail-open-document-text.png" alt="" height=16 width=16></span>Offene</a></li>
                            <li class="<?=$secondthree?>"><a href="tickets_geschlossen.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/mail.png" alt="" height=16 width=16></span>Geschlossene</a></li>
                        </ul>
                    </li>
                    <li class="<?=$third?>">
                        <a href="javascript:void(0);" class="<?=$third1?>"><img src="img/icons/packs/fugue/16x16/equalizer.png" alt="" height=16 width=16>Einstellungen</a>
                        <ul>
                            <li class="<?=$thirdone?>"><a href="account.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/user-black.png" alt="" height=16 width=16></span>Mein Account</a></li>
                            <?php
                                   if($_SESSION['utype'] == "1" || $_SESSION['utype'] == "3"){     
                            ?>
                            <li class="<?=$thirdtwo?>"><a href="user.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/ui-text-field-password.png" alt="" height=16 width=16></span>Benutzerverwaltung</a></li>
                            <li class="<?=$thirdthree?>"><a href="settings.php"><span class="icon"><img src="img/icons/packs/fugue/16x16/at-sign.png" alt="" height=16 width=16></span>E-Mail Einstellungen</a></li>
                            <?php
                                   }   
                            ?>
                        </ul>
                    </li>
               </ul>
          </nav><!-- End of nav -->
     </div><!-- End of .top -->
     <div class="bottom sticky">
          <div class="divider"></div>
     </div><!-- End of .bottom -->
</aside><!-- End of sidebar -->