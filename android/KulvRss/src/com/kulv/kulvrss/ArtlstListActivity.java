package com.kulv.kulvrss;

import com.kulv.datafetch.Article;
import com.kulv.datafetch.Rss;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.NavUtils;
import android.view.MenuItem;

/**
 * An activity representing a list of Artlst. This activity has different
 * presentations for handset and tablet-size devices. On handsets, the activity
 * presents a list of items, which when touched, lead to a
 * {@link ArtlstDetailActivity} representing item details. On tablets, the
 * activity presents the list of items and item details side-by-side using two
 * vertical panes.
 * <p>
 * The activity makes heavy use of fragments. The list of items is a
 * {@link ArtlstListFragment} and the item details (if present) is a
 * {@link ArtlstDetailFragment}.
 * <p>
 * This activity also implements the required
 * {@link ArtlstListFragment.Callbacks} interface to listen for item selections.
 */
public class ArtlstListActivity extends FragmentActivity implements
		ArtlstListFragment.Callbacks {

	String m_rssid = "";
	
	/**
	 * Whether or not the activity is in two-pane mode, i.e. running on a tablet
	 * device.
	 */
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_artlst_list);

		
		getActionBar().setDisplayHomeAsUpEnabled(true);
		// TODO: If exposing deep links into your app, handle intents here.
		
		Bundle bundle=getIntent().getExtras();
		m_rssid = bundle.getString(ArtlstListFragment.ARG_RSS_ID);
		
    	ArtlstListFragment listfrag = (ArtlstListFragment) getSupportFragmentManager().findFragmentById(R.id.artlst_list) ;
    	listfrag.article = new Article( m_rssid) ;
    	listfrag.article.FetchArticleList();
		listfrag.showArticleData( ) ;
	}

	/**
	 * Callback method from {@link ArtlstListFragment.Callbacks} indicating that
	 * the item with the given ID was selected.
	 */
	@Override
	public void onItemSelected(String id) {
		
		// In single-pane mode, simply start the detail activity
		// for the selected item ID.
		String aid = id ;
		Intent detailIntent = new Intent(this, ArtlstDetailActivity.class);
		detailIntent.putExtra(ArtlstDetailFragment.ARG_ARTICLE_ID, aid);
		detailIntent.putExtra(ArtlstDetailFragment.ARG_RSS_ID, this.m_rssid);//rss id
		startActivity(detailIntent);

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
}
