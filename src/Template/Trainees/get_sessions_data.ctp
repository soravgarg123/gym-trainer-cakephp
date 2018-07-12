<?php for ($i=1; $i <= $session; $i++) { ?>
   <div class="session_block ">
      <div class="session_block_head">
       Session <?php echo $i; ?> | <span class="notes-label" main="<?php echo $i; ?>" title="Click here to save notes"> Notes </span>
        <div class="pop_over_main" id="notes_window_<?php echo $i; ?>" style="display:none;">
              <div class="pop_over">
                <textarea class="form-control" placeholder="message" name="notes[]"></textarea>
                <a href="javascript:void(0);" class="btn_okay notes-cancel-btn">cancel</a><a href="javascript:void(0);" class="btn_okay notes-save-btn">save</a>
             </div>
        </div>
      </div>
      <div class="session_block_content">
        <ul>
          <?php $timestamp = strtotime(date('Y-m-d')) + 60*60; ?>
          <li id="modify_date_time_<?php echo $i; ?>">
            <div class="icon_block modify_date_time" id="modify_btn_<?php echo $i; ?>" main="<?php echo $i; ?>" title="Modify Date & Time"><i class="fa fa-pencil"></i> </div>
            <div class="modify_date_time1 save_cancel_section_<?php echo $i; ?>" style="display:none;">
              <div class="icon_block cancel-modify-btn" id="cancel_modify_btn_<?php echo $i; ?>" main="<?php echo $i; ?>" title="Cancel"><i class="fa fa-times"></i> </div>
              <div class="icon_block save-modify-btn" id="save_modify_btn_<?php echo $i; ?>" main="<?php echo $i; ?>" title="Save"><i class="fa fa-check"></i> </div>
            </div>
            <div class="text_block" id="date_time_block_<?php echo $i; ?>"><?php echo date('F', strtotime(date('Y-m-d'))); ?> <?php echo date('d', strtotime(date('Y-m-d'))); ?>th <?php echo date('Y', strtotime(date('Y-m-d'))); ?> </br> <?php echo date('h:i:A', strtotime(date('Y-m-d'))); ?> - <span><?php echo date('h:i:A', $timestamp); ?></span></div>
          </li>
          <li id="map_icon_<?php echo $i; ?>">
            <div class="icon_block select_location" main="<?php echo $i; ?>" title="Select Location"><i class="fa fa-map-marker"></i> </div>
            <div class="text_wrap">
            <div class="text_block" id="location_text_<?php echo $i; ?>" title="<?php echo (isset($profile_details[0]['city_name'])) ? $profile_details[0]['city_name']."-".$profile_details[0]['state_name'].",".$profile_details[0]['country_name'] : "" ?>"><?php echo (isset($profile_details[0]['city_name'])) ? $profile_details[0]['city_name']."-".$profile_details[0]['state_name'].",".$profile_details[0]['country_name'] : "" ?></div>
          </div>
          </li>
        </ul>
        <div class="button_box clearfix">
          <div class="button_in">Select Training Preference <div class="pop_over_main"> <span class="icon_block question_icon"><i class="fa fa-question"></i></span>
           </div>
         </div>
          <ul>
            <li class="active"  id="local_btn_<?php echo $i; ?>"><a href="javascript:void(0);" class="preference-btn" main="<?php echo $i; ?>" type="0">local</a></li>
            <li  id="virtual_btn_<?php echo $i; ?>"><a href="javascript:void(0);" class="preference-btn" main="<?php echo $i; ?>" type="1">virtual</a></li>
          </ul>
          <input type="hidden" name="prefernce[]" id="prefernce_val_<?php echo $i; ?>" value="0">
          <input type="hidden" name="locations[]" id="location_val_<?php echo $i; ?>" value="50.447978,-104.6066559">
          <input type="hidden" name="modified_dates[]" id="date_val_<?php echo $i; ?>" value="<?php echo date('Y-m-d'); ?>">
          <input type="hidden" name="modified_times[]" id="time_val_<?php echo $i; ?>" value="<?php echo date('h:i:A', strtotime(date('Y-m-d'))); ?>-<?php echo date('h:i:A', $timestamp); ?>">
        </div>
      </div>
   </div>
  <?php } ?>