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
public class Rss {
	public static String rsslisturl = "http://kulvrss.chenzhenianqing.cn/api/getmenu.php" ;
	public static List<RssItem> RssList = new ArrayList<RssItem>();

	public static Map<String, RssItem> RssList_Map = new HashMap<String, RssItem>();

	
	
	public static void FetchRssList(){
		HttpRequest rqst = HttpRequest.get(rsslisturl) ;
		int code = rqst.code(); 
		if( code != 200 ){
			UtilsFunc.InfoDialog(null, "RSS列表获取失败，HTTP错我码:"+code) ;
			return ;
		}
		
		String response = rqst.body();
		try {
			Rss.RssList.clear() ;
			JSONArray jsrsslist = new JSONArray(response);  
			for( int i=0; i< jsrsslist.length(); i++){
	            
	            JSONObject rss = (JSONObject)jsrsslist.get(i) ;
	            String name = (String)rss.get("name") + " (" + (String)rss.get("unreadcount") + ")" ;
	            addItem(new RssItem((String)rss.get("id"), name));
		    }
		
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			//UtilsFunc.InfoDialog(test1.this, "JSON解析异常"+e.getMessage());
		} 

		
	}
	private static void addItem(RssItem item) {
		RssList.add(item);
		RssList_Map.put(item.id, item);
	}

	/**
	 * A dummy item representing a piece of content.
	 */
	public static class RssItem {
		public String id;
		public String content;

		public RssItem(String id, String content) {
			this.id = id;
			this.content = content;
		}

		@Override
		public String toString() {
			return content;
		}
	}
}