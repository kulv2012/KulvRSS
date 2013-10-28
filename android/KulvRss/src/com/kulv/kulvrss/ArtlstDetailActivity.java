package com.kulv.kulvrss;

import org.json.JSONException;

import com.kulv.datafetch.ArticleInfo;
import com.kulv.utils.UtilsFunc;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.NavUtils;
import android.view.MenuItem;

/**
 * An activity representing a single Artlst detail screen. This activity is only
 * used on handset devices. On tablet-size devices, item details are presented
 * side-by-side with a list of items in a {@link ArtlstListActivity}.
 * <p>
 * This activity is mostly just a 'shell' activity containing nothing more than
 * a {@link ArtlstDetailFragment}.
 */
public class ArtlstDetailActivity extends FragmentActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_artlst_detail);

		// Show the Up button in the action bar.
		getActionBar().setDisplayHomeAsUpEnabled(true);

		// savedInstanceState is non-null when there is fragment state
		// saved from previous configurations of this activity
		// (e.g. when rotating the screen from portrait to landscape).
		// In this case, the fragment will automatically be re-added
		// to its container so we don't need to manually add it.
		// For more information, see the Fragments API guide at:
		//
		// http://developer.android.com/guide/components/fragments.html
		//
		if (savedInstanceState == null) {
			// Create the detail fragment and add it to the activity
			// using a fragment transaction.
			Bundle arguments = new Bundle();
			String rssid = getIntent().getStringExtra(ArtlstDetailFragment.ARG_RSS_ID) ;
			String aid = getIntent().getStringExtra(ArtlstDetailFragment.ARG_ARTICLE_ID) ;
			ArticleInfo tmpartinfo = new ArticleInfo(rssid, aid);
			tmpartinfo.FetchArticleInfo();
			
			
			
			arguments.putString(ArtlstDetailFragment.ARG_ARTICLE_ID, aid);
			arguments.putString(ArtlstDetailFragment.ARG_RSS_ID, rssid);
			
			try {
				arguments.putString(ArtlstDetailFragment.ARG_TITLE_ID, tmpartinfo.jsatlinfo.getString("title"));
				arguments.putString(ArtlstDetailFragment.ARG_CONTENT_ID, tmpartinfo.jsatlinfo.getString("content"));
				arguments.putString(ArtlstDetailFragment.ARG_LINK_ID, tmpartinfo.jsatlinfo.getString("link"));
				
				setTitle( tmpartinfo.jsatlinfo.getString("title") );
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				arguments.putString(ArtlstDetailFragment.ARG_TITLE_ID, "参数处理异常");
				arguments.putString(ArtlstDetailFragment.ARG_CONTENT_ID, "参数处理异常");
				arguments.putString(ArtlstDetailFragment.ARG_LINK_ID, "参数处理异常");
			}
			
			
			ArtlstDetailFragment fragment = new ArtlstDetailFragment();
			fragment.setArguments(arguments);
			getSupportFragmentManager().beginTransaction()
					.add(R.id.artlst_detail_container, fragment).commit();
		}
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
			Intent detailIntent = new Intent(this, ArtlstListActivity.class);//打开文章列表
            detailIntent.putExtra(ArtlstListFragment.ARG_RSS_ID, getIntent().getStringExtra(ArtlstDetailFragment.ARG_RSS_ID) );
            
			NavUtils.navigateUpTo(this, detailIntent);
			//NavUtils.navigateUpTo(this, new Intent(this, ArtlstListActivity.class));
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
}
