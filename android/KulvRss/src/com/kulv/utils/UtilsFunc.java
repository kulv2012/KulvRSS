package com.kulv.utils;

import com.kulv.kulvrss.ItemListActivity;
import com.kulv.kulvrss.test1;

import android.R;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnClickListener;
import android.widget.EditText;
import android.widget.Toast;





public class UtilsFunc {

	public static void InputDialog(Context context, String title ){
		
		AlertDialog.Builder builder = new AlertDialog.Builder(context) ;
		
		builder.setTitle(title);
		builder.setIcon(android.R.drawable.ic_dialog_info);
		builder.setView(new EditText(context));
		builder.setCancelable(false);
		builder.setPositiveButton("确定", new OnClickListener() {
		  @Override
		  public void onClick(DialogInterface dialog, int which) {
			  
			  dialog.dismiss(); 
			  //context.finish();
		  }
		});
		builder.setNegativeButton("取消", new OnClickListener() {
		  @Override
		  public void onClick(DialogInterface dialog, int which) {
		    dialog.dismiss();
		  }
		});
		Dialog dialog = builder.create();
		dialog.show();
	}
	
	public static void InfoDialog( Context context , String info ){
		new AlertDialog.Builder(context).setTitle("提示标题").setPositiveButton("确定",null).setMessage(info).setCancelable(false).show();   
	}
	
	public static void InfoToast(Context context , String info ){
		Toast.makeText(context ,  info, Toast.LENGTH_SHORT).show();
	}
}
