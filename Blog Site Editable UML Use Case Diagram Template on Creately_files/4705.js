if("object"==typeof CE2&&(CE2.uid||CE2.data))throw Error("CE: multiple userscripts installed");"undefined"==typeof CE2&&(CE2={}),CE2.data={uid:274705,updated_at:1594297186,ce_app_url:"https://app.crazyegg.com",status:"no data available"},CE2.userDataToJs=function(_){for(var t=[["uid","uid"],["snapshots","snapshots"],["status","status"],["flows","flows"],["pageEdits","page_edits"],["sites","sites"],["USER_SCRIPT_VERSION","updated_at"],["__CE_HOST__","ce_app_url"],["COMMON_SCRIPT","common_script_url"],["COMMON_SCRIPT_SECURE","common_script_url"],["TRACKING_SCRIPT","tracking_script_url"],["TRACKING_SCRIPT_SECURE","tracking_script_url"],["AUTH_KEY","hud_auth_key"],["HUD","hud"],["GLOBAL_IP_BLOCK_LIST","global_ip_block_list"],["IS_USING_IP_BLOCKING","is_using_ip_blocking"],["TRACKING_DEST_NEW","v6_tracking_dest"],["TRACKING_DEST_NEW_SECURE","v6_secure_tracking_dest"],["DEST_V11","v11_tracking_dest"],["FT_DEST","flow_tracking_dest"],["PAGE_VIEWS_LIMIT_REACHED","page_views_limit_reached"],["NUMBER_OF_RECORDINGS","recordings_number"],["RECORDINGS_ACTIVATION","recordings_activation"],["ALLOW_RECORDINGS_2","recordings_2"],["ERROR_TRACKING","error_tracking"],["DEST_ERRORS_API","error_tracking_dest"],["DEST_ERRORS_API_DOMAIN","error_tracking_script_url"]],a=0;a<t.length;a++){var r=t[a];CE2.data[r[1]]&&(CE2[r[0]]=CE2.data[r[1]])}CE2.data.recordings_dest&&(CE2.SREC_DEST={record:CE2.data.recordings_dest,sample:CE2.data.recordings_sampling_dest})},CE2.userDataToJs(CE2.data);