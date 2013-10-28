package com.kulv.kulvrss;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebView;
import android.widget.TextView;

import com.kulv.datafetch.ArticleInfo;


/**
 * A fragment representing a single Artlst detail screen. This fragment is
 * either contained in a {@link ArtlstListActivity} in two-pane mode (on
 * tablets) or a {@link ArtlstDetailActivity} on handsets.
 */
public class ArtlstDetailFragment extends Fragment {
	/**
	 * The fragment argument representing the item ID that this fragment
	 * represents.
	 */
	public static final String ARG_RSS_ID = "rssid";
	public static final String ARG_ARTICLE_ID = "aid";
	public static final String ARG_TITLE_ID = "title";
	public static final String ARG_CONTENT_ID = "content";
	public static final String ARG_LINK_ID = "link";

	

	/**
	 * Mandatory empty constructor for the fragment manager to instantiate the
	 * fragment (e.g. upon screen orientation changes).
	 */
	public ArtlstDetailFragment() {
	}

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View rootView = inflater.inflate(R.layout.fragment_artlst_detail,
				container, false);
		
		String title = getArguments().getString("title");
		String content = getArguments().getString("content");
		
		
		// Show the dummy content as text in a TextView.
		//((TextView) rootView.findViewById(R.id.artlst_detail)).setText(content);
		WebView webview = (WebView) rootView.findViewById(R.id.artlst_detail_webview); 
		webview.getSettings().setJavaScriptEnabled(true);
		webview.getSettings().setSupportZoom(true);
		webview.getSettings().setBuiltInZoomControls(true);
		webview.loadDataWithBaseURL("", content, "text/html", "UTF-8", "");
		return rootView;
	}
}
