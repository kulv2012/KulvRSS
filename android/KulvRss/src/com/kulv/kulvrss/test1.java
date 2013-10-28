package com.kulv.kulvrss;

import com.kulv.utils.UtilsFunc;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.NavUtils;
import android.view.MenuItem;
import android.view.View; 
import android.widget.Button; 
import android.widget.EditText;
import android.widget.Toast;


import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.DialogInterface.OnClickListener;
import android.content.DialogInterface.OnMultiChoiceClickListener;


public class test1 extends Activity {

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // 载入main.xml Layout
        setContentView(R.layout.test1);

        getActionBar().setDisplayHomeAsUpEnabled(true);
        
        // 以findViewById()取得Button对象并添加事件onClickLisener
        Button bt1 = (Button) findViewById(R.id.bt1);
        bt1.setOnClickListener(new Button.OnClickListener() {
            public void onClick(View v) {
                //goToLayout2();
            	//new AlertDialog.Builder(test1.this).setTitle("提示标题").setMessage("这是提示内容").show();  
            	//UtilsFunc.InputDialog(test1.this, "aaaa") ;
            	//UtilsFunc.InfoDialog(test1.this, "fegner") ;
            	
            	UtilsFunc.InfoToast(test1.this, "hello ,i am toast");
            }
        });
    } 

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		switch (item.getItemId()) {
		case android.R.id.home:
			// This ID represents the Home or Up button. In the case of this
			// activity, the Up button is shown. Use NavUtils to allow users
			// to navigate up one level in the application structure. For
			// more details, see the Navigation pattern on Android Design:
			//
			// http://developer.android.com/design/patterns/navigation.html#up-vs-back
			//
			NavUtils.navigateUpTo(this, new Intent(this,
					ItemListActivity.class));
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	
    // 将layout由main.xml切换成mylayout.xml
    public void goToLayout2() {
        // 将layout改成mylayout
        setContentView(R.layout.test1);
        Button b2 = (Button) findViewById(R.id.bt1);
        b2.setOnClickListener(new Button.OnClickListener() {
            public void onClick(View v) {
                goToLayout1();
            }
        });
    } 

    // 将layout由mylayout.xml切换成main.xml
    public void goToLayout1() {
        setContentView(R.layout.test1);
        Button bt1 = (Button) findViewById(R.id.bt1);
        bt1.setOnClickListener(new Button.OnClickListener() {
            public void onClick(View v) {
                goToLayout2();
            }
        });
    } 
}