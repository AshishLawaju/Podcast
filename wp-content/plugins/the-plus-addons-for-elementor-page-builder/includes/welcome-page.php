<?php
echo '<div class="theplus-panel-welcome-page">';
	echo '<div class="theplus-panel-row">';
		echo '<div class="theplus-panel-col theplus-panel-col-35">';
			/*Welcome User Info*/
			echo '<div class="theplus-welcome-user-info theplus-p-20 theplus-mb-8">';
				echo '<div class="theplus-user-info">';
					$user = wp_get_current_user();
					if ( $user ){
						echo '<img src="'.esc_url( get_avatar_url( $user->ID ) ).'" class="theplus-avatar-img" />';
					}
					echo '<div class="theplus-welcom-author-name">'.esc_html__('Welcome ','tpebl').$user->display_name.',</div>';
				echo '</div>';
				echo '<div class="theplus-sec-subtitle theplus-text-white theplus-mt-8">'.esc_html__('You deserve a quick and easy way to design, create, and publish. Start your new journey with the Plus Addons for Elementor. Presenting an incredible new workflow for Elementor. Constructing high-quality designs have never been such a breeze.','tpebl').'</div>';
				echo '<div class="theplus-sec-border theplus-bg-white"></div>';
				echo '<ul class="theplus-panel-list">';
					echo '<li>'.esc_html__("120+ Powerful Widgets",'tpebl').'</li>';
					echo '<li>'.esc_html__("20+ Unique Features",'tpebl').'</li>';
					echo '<li>'.esc_html__("18+ Premium Templates",'tpebl').'</li>';
					echo '<li>'.esc_html__("300+ Ready UI Blocks",'tpebl').'</li>';
				echo '</ul>';
				
				echo '<a href="https://theplusaddons.com/free-vs-pro-compare/" class="theplus-panel-btn-outline theplus-text-white" title="'.esc_attr__('Free Vs Pro','tpebl').'" target="_blank">'.esc_html__('Free Vs Pro','tpebl').'</a>';
				echo '<small class="theplus-notice-text theplus-mt-8">'.esc_html__('Planning to 🚀 Upgrade to PRO?','tpebl').'</small>';
				echo '<small class="theplus-notice-text theplus-mt-8">'.esc_html__('Take advantage of a 30-day risk-free refund period.','tpebl').'</small>';
			echo '</div>';
			/*Welcome User Info*/
			/*Welcome Document*/
			echo '<div class="theplus-panel-sec theplus-welcome-doc theplus-p-20 theplus-mt-8 theplus-mb-8">';
				echo '<div class="theplus-sec-title">'.esc_html__('Documentation','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('We wrote every detail for you.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('Looking forward to knowing more about each widget & features we provide? That is the best way to learn before you start implementation or to find a solution of any issue you are having in the process. We have documented all possible points there.','tpebl').'</div>';
				echo '<a href="http://docs.posimyth.com/tpae/" class="theplus-panel-btn" title="'.esc_attr__('Read Documentation','tpebl').'" target="_blank">'.esc_html__('Read Documentation','tpebl').'</a>';
			echo '</div>';
			/*Welcome Document*/
			/*Welcome System Requirement*/
			$check_right_req = '<svg xmlns="http://www.w3.org/2000/svg" width="23.532" height="20.533" viewBox="0 0 23.532 20.533">
				  <path d="M6.9,15.626,0,8.73,2.228,6.5,6.9,11.064,17.729,0,20,2.388Z" transform="translate(4.307) rotate(16)"/>
				</svg>';
			$check_wrong_req = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.633" viewBox="0 0 20 19.633">
			  <g transform="translate(-102.726 -8.677)">
				<path id="Path_7597" data-name="Path 7597" d="M0,0,3.551.047,3.864,23.9.313,23.854Z" transform="translate(102.726 11.41) rotate(-45)"/>
				<path id="Path_7598" data-name="Path 7598" d="M0,0,23.854.313,23.9,3.864.047,3.551Z" transform="translate(103.093 25.578) rotate(-45)"/>
			  </g>
			</svg>';
			
			echo '<div class="theplus-panel-sec theplus-welcome-sys-req theplus-p-20 theplus-mt-8">';
				echo '<div class="theplus-sec-title">'.esc_html__('System Requirement','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Configuration needed to work smoothly.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				
				$php_check_req ='';
				if (version_compare(phpversion(), '7.1', '>')) {
					$php_check_req = '<span class="check-req-right">'.$check_right_req.'</span>';
				}else{
					$php_check_req = '<span class="check-req-wrong">'.$check_wrong_req.'</span>';
				}
				echo '<div class="sys-req-label"><span style="width:70%;">'.esc_html__('PHP Version : ','tpebl').phpversion().esc_html__(' Check','tpebl').'</span>'.$php_check_req.'</div>';
				
				$memory_check_req ='';
				$memory_limit = ini_get('memory_limit');
				if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
					if ($matches[2] == 'M') {
						$memory_limit = $matches[1] * 1024 * 1024;
					} else if ($matches[2] == 'K') {
						$memory_limit = $matches[1] * 1024;
					}
				}
				
				if ($memory_limit >= 512 * 1024 * 1024) {
					$memory_check_req = '<span class="check-req-right">'.$check_right_req.'</span>';
				}else{
					$memory_check_req = '<span class="check-req-wrong">'.$check_wrong_req.'</span>';
				}
				echo '<div class="sys-req-label"><span>'.esc_html__('Memory Limit : ','tpebl').'</br>'.ini_get('memory_limit').esc_html__(' Uncheck Required 512M','tpebl').'</span>'.$memory_check_req.'</div>';
				
				$gzip_check_req = '';
				if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
					$gzip_check_req = '<span class="check-req-right">'.$check_right_req.'</span>';
				}else{
					$gzip_check_req = '<span class="check-req-wrong">'.$check_wrong_req.'</span>';
				}
				echo '<div class="sys-req-label theplus-bm-0"><span>'.esc_html__('GZIp Enabled :','tpebl').'</span>'.$gzip_check_req.'</div>';
				echo '<a href="http://docs.posimyth.com/tpae/system-requirements-configurations/" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('Know More & Resolve','tpebl').'" target="_blank">'.esc_html__('Know More & Resolve','tpebl').'</a>';
			echo '</div>';
			/*Welcome System Requirement*/
		echo '</div>';
		echo '<div class="theplus-panel-col theplus-panel-col-65">';
			/*Welcome Change log*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-welcome-changelog theplus-mb-8">';
				echo '<div class="theplus-sec-title">'.esc_html__('What’s New?','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Notable additions made to The Plus Addons for Elementor.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-changelog-list">';
					echo '<div class="changelog-date">JUN 23,2021 <span class="changelog-version">Lite Version 5.0</span></div>';
						echo '<ul class="changelog-list">';
							echo '<li>'.esc_html__('Added : Age Gate','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Message Box','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Post Title','tpebl').'</li>';
						echo '</ul>';					
				echo '</div>';
				echo '<a href="https://wordpress.org/plugins/the-plus-addons-for-elementor-page-builder/#developers" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('change log','tpebl').'" target="_blank">'.esc_html__('Lite Full Change log','tpebl').'</a>';
				
				
				echo '<div class="theplus-sec-border" style="width:100%;height:1px;background:#DBDBDB;"></div>';
				echo '<div class="theplus-changelog-list">';
					echo '<div class="changelog-date">JUN 23,2021 <span class="changelog-version">Pro Version 5.0</span></div>';
						echo '<ul class="changelog-list">';	
							echo '<li>'.esc_html__('Added : Mouse Cursor','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Post Navigation','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Pre Loader','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Social Feed','tpebl').'</li>';
							echo '<li>'.esc_html__('Added : Social Reviews','tpebl').'</li>';
						echo '</ul>';					
				echo '</div>';
				echo '<a href="https://theplusaddons.com/changelog/" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('change log','tpebl').'" target="_blank">'.esc_html__('Pro Full Change log','tpebl').'</a>';
				
				
			echo '</div>';
			/*Welcome Change log*/
			/*Welcome FAQ*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-welcome-faq theplus-mt-8">';
				echo '<div class="theplus-sec-title">'.esc_html__('Frequently Asked Questions','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('You might have some, We have tried to answer them all.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-faq-section faq-active">';
					echo '<div class="faq-title"><span>'.esc_html__('Are you having Elementor Loading Error?','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('After activation of plugin, Are you having elementor editor’s loading error? If yes, That is the most common issue of elementor regarding to memory limit. You need to disable all unused widgets from The Plus and all other elementor addons you are using. With that, You need to increase your memory limit to 768M(You may do that using modification of wp-config file or reaching out to your hosting provider).','tpebl').'</div>';
				echo '</div>';
				echo '<div class="theplus-faq-section">';
					echo '<div class="faq-title"><span>'.esc_html__('How to get Help/Support?','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('You can get ','tpebl').'<a href="https://wordpress.org/support/plugin/the-plus-addons-for-elementor-page-builder/" target="_blank" class="panel-sec-color">'.esc_html__('Free support','tpebl').'</a>'.esc_html__(' and to get ','tpebl').'<a href="https://posimyth.ticksy.com" target="_blank" class="panel-sec-color">'.esc_html__('Premium support','tpebl').'</a>'.esc_html__(' comes with Pro plan. Join our ','tpebl').'<a href="https://www.facebook.com/groups/theplus4elementor/" target="_blank" class="panel-sec-color">'.esc_html__('Facebook channel ','tpebl').'</a>'.esc_html__(' to get help from community.','tpebl').'</div>';
				echo '</div>';
				echo '<div class="theplus-faq-section">';
					echo '<div class="faq-title"><span>'.esc_html__('What is this Performance option about?','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('First of all, Performance is our highest priority. We have setup caching architecture in which, It generates One CSS & One JS files for each page. Those files combine & minify code of widgets used on those pages in single file. That means, If you have Just one widget from The Plus Addons on your page, It will make one CSS file and One JS file which will have that widget’s assets. So, It will make your plugin 100% modular with highest possible performance.','tpebl').'</div>';
				echo '</div>';
				echo '<div class="theplus-faq-section">';
					echo '<div class="faq-title"><span>'.esc_html__('When and Why Need to remove cache?','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('When you make any updated in your page and If that is not reflecting properly in frontend, You need to remove cache. When you click on Purge All Cache, It will remove all those individual files and It will start creating those files when you visit that page for first time.','tpebl').'</div>';
				echo '</div>';
				echo '<div class="theplus-faq-section">';
					echo '<div class="faq-title"><span>'.esc_html__('What If I want to remove cache of only one page?','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('You can do that from admin bar of page editor. That is available on top for all pages you check from front end. You will see option “The Plus Performance” -> “Purge Current Page”.','tpebl').'</div>';
				echo '</div>';
				echo '<div class="theplus-faq-section">';
					echo '<div class="faq-title"><span>'.esc_html__('Site is not working well even after removing cache at frontend.','tpebl').'</span><span class="faq-icon-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="9.4" height="6.1" viewBox="0 0 9.4 6.1"><path d="M6.7,8.1,2,3.4,3.4,2,6.7,5.3,10,2l1.4,1.4Z" transform="translate(11.4 8.1) rotate(180)"/></svg></span></div>';
					echo '<div class="faq-content">'.esc_html__('If your website is not working well even after removing cache from above button. You need to check your 3rd party caching plugin and remove cache from there. After that try to remove your browser cache by pressing Hard Reload and/or try on incognito mode.','tpebl').'</div>';
				echo '</div>';
				echo '<a href="#" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('More FAQs','tpebl').'" target="_blank">'.esc_html__('More FAQs','tpebl').'</a>';
			echo '</div>';
			/*Welcome FAQ*/
		echo '</div>';
	echo '</div>';
	/*Video Tutorial*/
	echo '<div class="theplus-panel-row theplus-mt-50">';
		echo '<div class="theplus-panel-col theplus-panel-col-100">';
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-welcome-video">';
				echo '<div class="theplus-sec-title">'.esc_html__('Video Tutorials','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Checkout Few of our latest video tutorials','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				
				echo '<div class="theplus-panel-row theplus-panel-relative">';
					echo '<a href="https://www.youtube.com/playlist?list=PLFRO-irWzXaLK9H5opSt88xueTnRhqvO5 " class="theplus-more-video" target="_blank">'.esc_html__("Our Full Playlist",'tpebl').'</a>';
					echo '<div class="theplus-panel-col theplus-panel-col-25">';
						echo '<a href="https://youtu.be/HY5KlYuWP5k" class="theplus-panel-video-list" target="_blank">';
							echo '<img src="'.L_THEPLUS_URL.'/assets/images/video-tutorial/video-1.jpg" />';
						echo '</a>';
					echo '</div>';
					echo '<div class="theplus-panel-col theplus-panel-col-25">';
						echo '<a href="https://youtu.be/9-8Ftlb79tI" class="theplus-panel-video-list" target="_blank">';
							echo '<img src="'.L_THEPLUS_URL.'/assets/images/video-tutorial/video-2.jpg" />';
						echo '</a>';
					echo '</div>';
					echo '<div class="theplus-panel-col theplus-panel-col-25">';
						echo '<a href="https://youtu.be/Bwp3GBOlkaw" class="theplus-panel-video-list" target="_blank">';
							echo '<img src="'.L_THEPLUS_URL.'/assets/images/video-tutorial/video-3.jpg" />';
						echo '</a>';
					echo '</div>';
					echo '<div class="theplus-panel-col theplus-panel-col-25">';
						echo '<a href="https://youtu.be/kl2xSnl2YqM" class="theplus-panel-video-list" target="_blank">';
							echo '<img src="'.L_THEPLUS_URL.'/assets/images/video-tutorial/video-4.jpg" />';
						echo '</a>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	/*Video Tutorial*/
	/*Welcome Bottom Section*/
	echo '<div class="theplus-panel-row theplus-mt-8 tp-mt-8-remove">';
		echo '<div class="theplus-panel-col theplus-panel-col-50" style="align-content: flex-start;">';
			/*technical support*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-mb-8 theplus-welcome-tech-sup">';
				echo '<div class="theplus-sec-title">'.esc_html__('Technical Support','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Let’s find a solutions for your all your queries.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('Tried everything but not found a solution? Our premium support team is always there for your backup. Just a few quick ','tpebl').'<a href="http://docs.posimyth.com/tpae/steps-to-follow-before-submitting-a-support-ticket/" target="_blank" class="panel-sec-color">'.esc_html__('steps to take before submitting a ticket.','tpebl').'</a>'.esc_html__(' You may read our ','tpebl').'<a href="https://theplusaddons.com/terms-conditions/" target="_blank" class="panel-sec-color">'.esc_html__('Support Policy','tpebl').'</a>'. esc_html__(' to find out, Which things are covered.','tpebl').'</div>';
				
				echo '<div class="support-point theplus-mt-8"><span><svg id="Support" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"><path d="M24.167,9.167h-2.5V7.38C21.667,3.966,17.779,0,12.5,0S3.333,3.968,3.333,7.38V9.167H.833C0,9.167,0,9.712,0,10v8.333c0,.288,0,.833.833.833h2.5c.833,0,.833-.545.833-.833V7.381c0-2.871,3.717-6.339,8.333-6.339s8.333,3.467,8.333,6.339V20.9c0,1.113-.9,2.435-2.017,2.435H17.5V22.5c0-.288,0-.833-.833-.833H12.973a1.635,1.635,0,0,0-1.513,1.717A1.607,1.607,0,0,0,12.973,25h3.693c.833,0,.833-.544.833-.833h1.317a3.079,3.079,0,0,0,2.85-3.268V19.167h2.5c.833,0,.833-.545.833-.833V10C25,9.711,25,9.167,24.167,9.167Z" fill="#666"/><path d="M41.209,17.68V16.04c0-3.127-3.992-5.672-8.6-5.672S24,12.92,24,16.057v1.437c0,2.978,3.752,7.4,8.6,7.4,4.5,0,8.6-3.966,8.6-7.212Z" transform="translate(-20.104 -8.685)" fill="#666"/></svg></span><span>'.esc_html__('Support Time : Mon-Fri | 9 AM to 6 PM (Time Zone :UTC+5:30)','tpebl').'</span></div>';
				
				echo '<div class="support-point theplus-mb-8"><span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24.936" viewBox="0 0 25 24.936"><path d="M19.617,0a5.141,5.141,0,0,0-4.185,2.111,1.038,1.038,0,0,0,.5,1.6,11.444,11.444,0,0,1,2.8,1.406L17.809,6.35a9.853,9.853,0,0,0-10.993,0L5.889,5.117A11.371,11.371,0,0,1,8.735,3.694a1.041,1.041,0,0,0,.506-1.608A5.149,5.149,0,0,0,5.071,0,5.218,5.218,0,0,0,1,8.5a1.04,1.04,0,0,0,.808.385c.019,0,.039,0,.058,0a1.034,1.034,0,0,0,.817-.477A11.541,11.541,0,0,1,5.061,5.743l.926,1.235a9.832,9.832,0,0,0-1.44,13.64L2.018,24.111a.52.52,0,0,0,.119.726.514.514,0,0,0,.3.1.519.519,0,0,0,.421-.216l2.385-3.3a9.834,9.834,0,0,0,14.13,0l2.385,3.3a.519.519,0,1,0,.841-.608l-2.526-3.494a9.832,9.832,0,0,0-1.44-13.64l.925-1.235a11.584,11.584,0,0,1,2.4,2.709,1.039,1.039,0,0,0,.812.48l.065,0a1.037,1.037,0,0,0,.8-.375A5.224,5.224,0,0,0,19.617,0ZM17.874,9.718l-5.2,5.195a.515.515,0,0,1-.734,0L8.828,11.8a.52.52,0,1,1,.735-.735l2.75,2.75L17.14,8.984a.519.519,0,1,1,.733.735Z" transform="translate(0.156 0)" fill="#666"/></svg></span><span>'.esc_html__('Average Response Time : 24 Hours (Weekdays)','tpebl').'</span></div>';
				
				echo '<a href="https://posimyth.ticksy.com" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('Premium Support','tpebl').'" target="_blank">'.esc_html__('Premium Support','tpebl').'</a>';
				echo '<a href="https://wordpress.org/support/plugin/the-plus-addons-for-elementor-page-builder/" class="theplus-panel-btn-outline-2 theplus-mt-8" title="'.esc_attr__('Free Support','tpebl').'" target="_blank">'.esc_html__('Free Support','tpebl').'</a>';
			echo '</div>';
			/*technical support*/
			/*Social*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-mt-8 theplus-welcome-social">';
				echo '<div class="theplus-sec-title">'.esc_html__('We are social','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Join us to get regular Social Updates.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('Get to know about plugin updates, tips & tricks, New Offers and lots more from our social media accounts.','tpebl').'</div>';
				echo '<a href="https://www.facebook.com/groups/theplus4elementor/" class="theplus-panel-social theplus-mt-8" title="'.esc_attr__('facebook','tpebl').'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="21.356" height="17" viewBox="0 0 640 512"><path d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM320 256c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm244 192h-40c-15.2 0-29.3 4.8-41.1 12.9 9.4 6.4 17.9 13.9 25.4 22.4 4.9-2.1 10.2-3.3 15.7-3.3h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm304.1 180c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM480 432c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zM157.1 268.9c-11.9-8.1-26-12.9-41.1-12.9H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c5.5 0 10.8 1.2 15.7 3.3 7.5-8.5 16.1-16 25.4-22.4z" fill="#8072fc" fill-rule="evenodd"/></svg></a>';
				echo '<a href="http://instagram.com/theplus_addons_elementor/" class="theplus-panel-social theplus-mt-8" title="'.esc_attr__('instagram','tpebl').'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20"><path d="M10,1.778a30.662,30.662,0,0,1,4,.111,5.154,5.154,0,0,1,1.889.333,3.9,3.9,0,0,1,1.889,1.889A5.154,5.154,0,0,1,18.111,6c0,1,.111,1.333.111,4a30.662,30.662,0,0,1-.111,4,5.154,5.154,0,0,1-.333,1.889,3.9,3.9,0,0,1-1.889,1.889A5.154,5.154,0,0,1,14,18.111c-1,0-1.333.111-4,.111a30.662,30.662,0,0,1-4-.111,5.154,5.154,0,0,1-1.889-.333,3.9,3.9,0,0,1-1.889-1.889A5.154,5.154,0,0,1,1.889,14c0-1-.111-1.333-.111-4a30.662,30.662,0,0,1,.111-4,5.154,5.154,0,0,1,.333-1.889A3.991,3.991,0,0,1,3,3a1.879,1.879,0,0,1,1.111-.778A5.154,5.154,0,0,1,6,1.889a30.662,30.662,0,0,1,4-.111M10,0A32.83,32.83,0,0,0,5.889.111,6.86,6.86,0,0,0,3.444.556,4.35,4.35,0,0,0,1.667,1.667,4.35,4.35,0,0,0,.556,3.444,5.063,5.063,0,0,0,.111,5.889,32.83,32.83,0,0,0,0,10a32.83,32.83,0,0,0,.111,4.111,6.86,6.86,0,0,0,.444,2.444,4.35,4.35,0,0,0,1.111,1.778,4.35,4.35,0,0,0,1.778,1.111,6.86,6.86,0,0,0,2.444.444A32.83,32.83,0,0,0,10,20a32.83,32.83,0,0,0,4.111-.111,6.86,6.86,0,0,0,2.444-.444,4.662,4.662,0,0,0,2.889-2.889,6.86,6.86,0,0,0,.444-2.444C19.889,13,20,12.667,20,10a32.83,32.83,0,0,0-.111-4.111,6.86,6.86,0,0,0-.444-2.444,4.35,4.35,0,0,0-1.111-1.778A4.35,4.35,0,0,0,16.556.556,6.86,6.86,0,0,0,14.111.111,32.83,32.83,0,0,0,10,0m0,4.889A5.029,5.029,0,0,0,4.889,10,5.111,5.111,0,1,0,10,4.889m0,8.444A3.274,3.274,0,0,1,6.667,10,3.274,3.274,0,0,1,10,6.667,3.274,3.274,0,0,1,13.333,10,3.274,3.274,0,0,1,10,13.333m5.333-9.889a1.222,1.222,0,1,0,1.222,1.222,1.233,1.233,0,0,0-1.222-1.222" fill="#8072fc" fill-rule="evenodd"/></svg></a>';
				echo '<a href="https://www.facebook.com/theplusaddonsforelementor" class="theplus-panel-social theplus-mt-8" title="'.esc_attr__('facebook','tpebl').'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="8.356" height="16" viewBox="0 0 8.356 16"><path d="M85.422,16V8.711h2.489l.356-2.844H85.422V4.089c0-.8.267-1.422,1.422-1.422h1.511V.089C88,.089,87.111,0,86.133,0a3.431,3.431,0,0,0-3.644,3.733V5.867H80V8.711h2.489V16Z" transform="translate(-80)" fill="#8072fc" fill-rule="evenodd"/></svg></a>';
				echo '<a href="https://www.youtube.com/playlist?list=PLFRO-irWzXaLK9H5opSt88xueTnRhqvO5" class="theplus-panel-social theplus-mt-8" title="'.esc_attr__('youtube','tpebl').'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" fill="#8072fc" fill-rule="evenodd"/></svg></a>';
			echo '</div>';
			/*Social*/
		echo '</div>';
		echo '<div class="theplus-panel-col theplus-panel-col-50">';
			/*Rate Us*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-mb-8 theplus-welcome-rate-us">';
				echo '<div class="theplus-sec-title">'.esc_html__('Rate Us','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Your generous rating motivates us to do even better.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('Your reviews will help us to build better product for you. It even helps other Elementor users to know about our product and your experience.','tpebl').'</div>';
				echo '<a href="https://wordpress.org/plugins/the-plus-addons-for-elementor-page-builder/#reviews" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('Rate on WordPress','tpebl').'" target="_blank">'.esc_html__('Rate on WordPress','tpebl').'</a>  
				<a href="https://www.facebook.com/theplusaddonsforelementor/reviews/" class="theplus-panel-btn-outline-2 theplus-mt-8" title="'.esc_attr__('Rate on Facebook','tpebl').'" target="_blank">'.esc_html__('Rate on Facebook','tpebl').'</a>';
			echo '</div>';
			/*Rate Us*/
			/*feedback*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-mt-8 theplus-mb-8 theplus-welcome-feedback">';
				echo '<div class="theplus-sec-title">'.esc_html__('Any Feedback or Suggestions?','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Wish to see your favorite feature in The Plus Addons ?','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('#CraftYourPerfectAddon Byline- Who knows where great ideas start? Your feedback helps us grow together. #ThePlusFamily ♥','tpebl').'</div>';
				echo '<a href="http://roadmap.theplusaddons.com/" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('Share Feedback','tpebl').'" target="_blank">'.esc_html__('Suggest Feature','tpebl').'</a>';
			echo '</div>';
			/*feedback*/
			/*subscriber*/
			echo '<div class="theplus-panel-sec theplus-p-20 theplus-mt-8 theplus-welcome-subscriber">';
				echo '<div class="theplus-sec-title">'.esc_html__('Join 14,573 Subscribers','tpebl').'</div>';
				echo '<div class="theplus-sec-subtitle">'.esc_html__('Get the latest updates, Offers and more on your email.','tpebl').'</div>';
				echo '<div class="theplus-sec-border"></div>';
				echo '<div class="theplus-sec-desc">'.esc_html__('Want to join our newsletter? We share tricks & tips related to The Plus Addons for Elementor and WordPress itself. On top of that, You will get timely notifications of new plugin updates, discount offers and lots more.','tpebl').'</div>';
				echo '<a href="https://theplusaddons.com/#tpf-footer" class="theplus-panel-btn theplus-mt-8" title="'.esc_attr__('Subscribe Us','tpebl').'" target="_blank">'.esc_html__('Subscribe Us','tpebl').'</a>';
			echo '</div>';
			/*subscriber*/
		echo '</div>';
	echo '</div>';
	/*Welcome Bottom Section*/
echo '</div>';
?>