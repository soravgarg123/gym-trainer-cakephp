<?php include "trainer_dashboard.php"; ?>
     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                    <div id="msg_tab">
                    <div class="panel_block_heading">
                        <h4>Rate Plan</h4>
                    </div>
                    </div>
                      <div class="">
                    <div class="">
                <div class="conversation-wrap col-lg-3 col-md-3 col-sm-3">
                 <div class="msg-wrap" >
                     <div class="col-md-12">
                     <h4>Enter Hourly Rate</h4>
                     </div>
                 </div>

                 <div class="msg-wrap" >
                   <div class="col-md-12"></div>
                    <div class="col-md-1"><i class="fa fa-calculator" style="font-size:x-large"></i></div>
                    <div class="col-md-10">$<input type="text" name="rate" id="rate" style="width:60%;height:27px;padding-top:3px; border:1px solid #333" value="<?php echo $trainerratedetail[0]['rate_hour'];?>"> /Session</div>
                    <input type="hidden" name="rateid" id="rateid" value="<?php echo $trainerratedetail[0]['rate_id'];?>">
                

                 </div>


                 <div class="msg-wrap" >
                 <div class="col-md-8 text-center"><a href="javascript:" class="set_rate"><i class="fa fa-check" style="font-size:x-large"></i></a></div>
                  <div class="col-md-8 text-center"><b>accept</b></div>
                 
                 </div>



                </div>
                <div class="message-wrap col-lg-9 col-md-9 col-sm-9">
                    <div class="msg-wrap" id="chat_msgs">
                    <?php
                if(!empty($trainerratedetail)) { $rate1=1*$trainerratedetail[0]['rate_hour']-$trainerratedetail[0]['adgust1'];$rate2=3*$trainerratedetail[0]['rate_hour']-$trainerratedetail[0]['adgust2'];$rate3=10*$trainerratedetail[0]['rate_hour']-$trainerratedetail[0]['adgust3'];$rate4=20*$trainerratedetail[0]['rate_hour']-$trainerratedetail[0]['adgust4']; ?>
                
                  <div class='col-md-12 text-center'> <h4> RATE PLANS</h4>  </div><hr>
                  <div class='col-md-2' style='margin-right:10px;margin-top:5px' ></div> <div class='col-md-2 text-center' style='padding:10px;border: 2px solid #333;border-radius:3px;margin-right:10px;'> <p >1 Session</p> <p class="rate1">$<?php echo $rate1;?> </p> </div><div class='col-md-2 text-center' style='padding:10px;border: 2px solid #333;border-radius:3px;margin-right:10px;'> <p>2 Sessions</p> <p class="rate2">$<?php echo $rate2;?></p> </div><div class='col-md-2 text-center' style='padding:10px;border: 2px solid #333;border-radius:3px;margin-right:10px;'> <p>10 Sessions </p><p class="rate3">$<?php echo $rate3;?></p>  </div><div class='col-md-2 text-center' style='padding:10px;border: 2px solid #333;border-radius:3px;margin-right:10px;'> <p>20 Sessions</p> <p class="rate4">$<?php echo $rate4;?></p> </div><div class='col-md-1' ></div>

                 <div class='col-md-2 text-center' style='margin-right:10px;margin-top:5px'> adjustments: </div>  <div class='col-md-2 text-center' style='margin-right:10px;margin-top:5px'> <input type='text' ratet="1"  class="text-center adjust" id="adjust1" style='width:100%;height:27px;padding-top:3px; border:1px solid #333' value="<?php echo $trainerratedetail[0]['adgust1'];?>" > </div><div class='col-md-2 text-center' style='margin-right:10px;margin-top:5px'>  <input id="adjust2" class="text-center adjust" type='text' ratet="2" style='width:100%;height:27px;padding-top:3px; border:1px solid #333' value="<?php echo $trainerratedetail[0]['adgust2'];?>"> </div><div class='col-md-2 text-center' style='margin-right:10px;;margin-top:5px'>  <input class="text-center adjust" id="adjust3" type='text' ratet="3" style='width:100%;height:27px;padding-top:3px; border:1px solid #333' value="<?php echo $trainerratedetail[0]['adgust3'];?>"> </div><div class='col-md-2 text-center' style='margin-right:10px;margin-top:5px'>  <input id="adjust4" class="text-center adjust" ratet="4" type='text'  style='width:100%;height:27px;padding-top:3px; border:1px solid #333' value="<?php echo $trainerratedetail[0]['adgust4'];?>"> </div>
                 <div class='col-md-1' > <div class="col-md-12 text-center"><a href="javascript:" class="set_adjust"><i class="fa fa-check" style="font-size:x-large"></i></a></div>
                  <div class="col-md-12 text-center"><b>accept</b></div> </div>

          
              <?php } ?>
                    </div>

                    <!-- <div class="send-wrap ">
                        <textarea class="form-control send-message" rows="3" placeholder="Write a reply..."></textarea>
                    </div>
                    
                    <div class="btn-panel">
                        <a href="" class="text-right bt  send-message-btn pull-right" role="button">Send Message</a>
                    </div> -->
                    
                </div>
                
                
            </div>
        
        </div>
                    
                    </div>
                </div>
            </div>
            
           
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

<!-- Side Users Messages Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $('body').on('click','.side_users',function(){
    var trainee_id = $(this).attr('main');
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainers/getMessages",
                type:"post",
                data:{trainee_id:trainee_id},
                dataType:"json",
                success: function(data){
                    $('#chat_msgs').html(data.message);
                }
            });
    });

    $('body').on('click','.set_rate',function(){


          var rate=$('#rate').val();
          var rateid=$('#rateid').val();
          if(rate=="")
          {
             $('#rate').val(); 
             $("#rate").css({"border-color": "red", 
             "border-weight":"1px", 
             "border-style":"solid"});
             return false;
          }
          else
          {
            $("#rate").css({"border-color": "#333", 
             "border-weight":"1px", 
             "border-style":"solid"});
            

          }
         $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainers/setrate",
                type:"post",
                data:{rate:rate,rateid:rateid},
                dataType:"json",
                success: function(data){
                    $('#chat_msgs').html(data.message);
                    location.reload();
                }
            });
    });
    


    $('body').on('click','.set_adjust',function(){


         
          var rateid=$('#rateid').val();
          var adjust1=$('#adjust1').val();
          var adjust2=$('#adjust2').val();
          var adjust3=$('#adjust3').val();
          var adjust4=$('#adjust4').val();

          var status=0;
          if(adjust1=="")
          {
           
             $("#adjust1").css({"border-color": "red", 
             "border-weight":"1px", 
             "border-style":"solid"});
            status=1;
          }
          else
          {
            $("#adjust1").css({"border-color": "#333", 
             "border-weight":"1px", 
             "border-style":"solid"});
           }

           if(adjust2=="")
          {
           
             $("#adjust2").css({"border-color": "red", 
             "border-weight":"1px", 
             "border-style":"solid"});
            status=1;
          }
          else
          {
            $("#adjust2").css({"border-color": "#333", 
             "border-weight":"1px", 
             "border-style":"solid"});
           }


           if(adjust3=="")
          {
           
             $("#adjust3").css({"border-color": "red", 
             "border-weight":"1px", 
             "border-style":"solid"});
            status=1;
          }
          else
          {
            $("#adjust3").css({"border-color": "#333", 
             "border-weight":"1px", 
             "border-style":"solid"});
           }


           if(adjust4=="")
          {
           
             $("#adjust4").css({"border-color": "red", 
             "border-weight":"1px", 
             "border-style":"solid"});
            status=1;
          }
          else
          {
            $("#adjust4").css({"border-color": "#333", 
             "border-weight":"1px", 
             "border-style":"solid"});
           }




           if(status==1)
           {
             return false;
           }
         
         $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainers/adjust",
                type:"post",
                data:{rateid:rateid,adjust1:adjust1,adjust2:adjust2,adjust3:adjust3,adjust4:adjust4},
                dataType:"json",
                success: function(data){
                    $('#chat_msgs').html(data.message);
                    location.reload();
                }
            });
    });







    $('body').on('keyup','.adjust',function(){

      rate="<?php echo $trainerratedetail[0]['rate_hour'];?>";
      adjust=$(this).val();
      ratetype=$(this).attr('ratet');
      if(ratetype==1)
      {
         ratetypes=1;
      }
       else if(ratetype==2)
      {
         ratetypes=3;
      }
      else if(ratetype==3)
      {
         ratetypes=10;
      }

       else if(ratetype==4)
      {
         ratetypes=20;
      }

      setfinalrate=rate*ratetypes-adjust;
    
      $('.rate'+ratetype).html("$"+setfinalrate);

    });


    });
</script>


<!-- Side Users Messages End -->
