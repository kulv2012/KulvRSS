package com.kulv.datafetch;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.kulv.kulvrss.ItemListActivity;
import com.kulv.kulvrss.test1;
import com.kulv.utils.HttpRequest;
import com.kulv.utils.UtilsFunc;

/**
 * Helper class for providing sample content for user interfaces created by
 * Android template wizards.
 * <p>
 * TODO: Replace all uses of this class before publishing your app.
 */
public class ArticleInfo {
	public String rssid  ;
	public String aid  ;
	
	public JSONObject jsatlinfo = null ;
	
	public String articleurl = "" ;
	
	public ArticleInfo(String tmprssid, String tmpaid ){
		rssid = tmprssid ;
		aid = tmpaid ;
		articleurl = "http://kulvrss.chenzhenianqing.cn/api/article.php?rssid="+rssid+"&aid="+aid ;
	}
	
	public void FetchArticleInfo(){
		HttpRequest rqst = HttpRequest.get(articleurl) ;
		int code = rqst.code(); 
		if( code != 200 ){
			UtilsFunc.InfoDialog(null, "RSS列表获取失败，HTTP错我码:"+code) ;
			return ;
		}
		
		String response = rqst.body();
		try {
			jsatlinfo = new JSONObject(response);  
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			//UtilsFunc.InfoDialog(test1.this, "JSON解析异常"+e.getMessage());
		} 

		
	}

}