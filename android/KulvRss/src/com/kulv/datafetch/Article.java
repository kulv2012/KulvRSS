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
public class Article {
	public String rssid  ;
	
	public String articlelisturl = "" ;
	public List<ArticleItem> AtlList = new ArrayList<ArticleItem>();

	public Map<String, ArticleItem> RssList_Map = new HashMap<String, ArticleItem>();

	public Article(String tmprssid ){
		rssid = tmprssid ;
		articlelisturl = "http://kulvrss.chenzhenianqing.cn/api/getatllist.php?rssid="+ rssid ;
	}
	
	public void FetchArticleList(){
		HttpRequest rqst = HttpRequest.get(articlelisturl) ;
		int code = rqst.code(); 
		if( code != 200 ){
			UtilsFunc.InfoDialog(null, "RSS列表获取失败，HTTP错我码:"+code) ;
			return ;
		}
		
		String response = rqst.body();
		try {
			AtlList.clear() ;
			JSONArray jsrsslist = new JSONArray(response);  
			for( int i=0; i< jsrsslist.length(); i++){
	            
	            JSONObject rss = (JSONObject)jsrsslist.get(i) ;
	            String name = "    ";
	            if( rss.get("isreaded").equals("0") ){
	            	name = "[未读] ";
	            }
	            name += (String)rss.get("title") ;
	            addItem(new ArticleItem((String)rss.get("aid"), name, rssid));
		    }
		
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			//UtilsFunc.InfoDialog(test1.this, "JSON解析异常"+e.getMessage());
		} 

		
	}
	private void addItem(ArticleItem item) {
		AtlList.add(item);
		RssList_Map.put(item.id, item);
	}

	/**
	 * A dummy item representing a piece of content.
	 */
	public static class ArticleItem {
		public String id;
		public String content;
		public String rssid ; 

		public ArticleItem(String id, String title, String rssid ) {
			this.id = id;
			this.content = title;
			this.rssid = rssid ;
		}

		@Override
		public String toString() {
			return content;
		}
	}
}