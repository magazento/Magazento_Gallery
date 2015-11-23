/**
 * jquery.freshline.portfolio - jQuery Plugin for portfolio gallery 
 * @version: 1.0 (22.11.11)
 * @requires jQuery v1.2.2 or later 
 * @author themepunch
 * All Rights Reserved, use only in freshline Templates or when Plugin bought at Envato ! 
**/






(function($,undefined){	
	
	
	////////////////////////////////////////
	// THE BACKGROUND PLUGIN STARTS HERE //
	///////////////////////////////////////
	
	$.fn.extend({
	
		
		// OUR PLUGIN HERE :)
		tpbackground: function(options) {
	
		
			
		////////////////////////////////
		// SET DEFAULT VALUES OF ITEM //
		////////////////////////////////
		var defaults = {	
			slideshow:0,
			cat:"",
			callback:"false"
		};
		
		options = $.extend({}, $.fn.tpbackground.defaults, options);
		
		return this.each(function() {
		
			var opt=options;
			var top=$(this);			
			
			
			if (opt.callback=="false") {
				top.find('div').each(function(i) {
					var $this=$(this);
					$this.css({'z-index':'2','position':'fixed','margin':'0px','padding':'0px','left':'0px','top':'0px','width':'100%','height':'100%','overflow':'hidden'});
					$this.data('id',i);
				});							
				loadNextBg(top,opt);			
			} else {
				
				loadNextBg(top,opt,opt.cat);
			}
		})
		
		
		//////////////////////////
		// LOAD NEXT BACKGROUND //
		//////////////////////////
		function loadNextBg(top,opt,cat) {
						
			var bgitem=null;
			// CHECK IF THE CATEGORY SELECTED IN THE GALLERY AVAILABLE
			if (cat!=null) {
				
				top.find('div').each(function() {
					var $this=$(this);					
					if ($this.data('category') == cat) bgitem=$this;																	
				});
			} else {
			
				if (top.find('.tp-bg-act-div-container').length == 0) {
					 bgitem=top.find('div:first');	
				 } else {							
					if (top.find('.tp-bg-act-div-container').data('id') < top.find('div').length-1) {
							bgitem=top.find('.tp-bg-act-div-container').next();	
							
					 } else {
							bgitem=top.find('div:first')						
					}
				}
			}
			
			
			if (bgitem!=null) {
                                if (!bgitem.hasClass('tp-bg-act-div-container') && bgitem!=null) {


                                        // MAKE THE NEW LOADED ITEM UNVISIBLE IF FADEIN SET
                                        if (bgitem.hasClass('fadein')) bgitem.css({'opacity':'0.0'});

                                        // SET SOURCE ,AND PREPARE THE DIV CONTAINER
                                        var src = bgitem.data('src');
                                        if (bgitem.hasClass('bg-tiled')) {
                                                bgitem.append('<div class="tp-bg-img-intern" style="width:'+$(window).width()+'px;height:'+$(window).height()+'px"><div style="width:100%;height:100%;background-image:url('+src+')"></div></div>');

                                        } else {
                                                bgitem.append('<img class="tp-bg-img-intern" src="'+src+'">');
                                        }


                                        // MARK ITEM WHICH IS NOW VIEWABLE, AND PREPARE IT TO KILL
                                        top.find('.tp-bg-act-div-container').addClass("to-kill-soon");
                                        top.find('.tp-bg-act-div-container').removeClass("tp-bg-act-div-container");

                                        bgitem.addClass("tp-bg-act-div-container");



                                        bgitem.waitForImages(function() {   
                                                //setTimeout(function() {
                                                        top.find(".to-kill-soon").animate({'opacity':'0.0'},{duration:500,queue:false});
                                                        top.find(".to-kill-soon").css({'z-index':'1'});
                                                        setTimeout(function() {
                                                                        top.find(".to-kill-soon").unbind("resize scroll")
                                                                        top.find(".to-kill-soon .tp-bg-img-intern").remove();
                                                                        top.find(".to-kill-soon").removeClass("to-kill-soon")},520);

                                                        if (opt.slideshow>0) setTimeout(function() {loadNextBg(top,opt);},parseInt(opt.slideshow,0));
                                                        prepareBG(bgitem);						
                                                //},00);
                                        });	
                                }
			}						
		}
		
		
	
		
		//////////////////////		
		// SET THE LI ITEMS //
		/////////////////////	
		function prepareBG(item) {
			
			$(window).bind('resize scroll', function() {resizeBackground(item)});						
			resizeBackground(item);
			if (item.hasClass('fadein')) {
				item.css({'opacity':'0.0'});
				item.animate({'opacity':'1.0'},{duration:500,queue:false});
			}
		}
		
		function resizeBackground(item) {
			
			var origImg = item.find('.tp-bg-img-intern');			
			var imgWidth = origImg.width();
			var imgHeight = origImg.height();
			
			// define image ratio
			var ratio = imgHeight/imgWidth;
			
			// get window sizes
			var winWidth = $(window).width() + 30;
			var winHeight = $(window).height();
			var winRatio = winHeight/winWidth;
			
			var newIWidth = 0;
			var newIHeight = 0;
			
			var newOWidth = 0;
			var newOHeight = 0;
			
			
			// resizing OutSide Fitting
			if (winRatio > ratio) {
				newOHeight = winHeight;
				newOWidth  = winHeight / ratio;
			} 
			else {
				newOWidth = winWidth;
				newOHeight = winWidth * ratio;				
			}
			
			// resizing InSide Fitting
			if (winRatio < ratio) {
				newIHeight = winHeight;
				newIWidth  = winHeight / ratio;
			} 
			else {
				newIWidth = winWidth;
				newIHeight = winWidth * ratio;				
			}
			
			
			// Inside Fitting
			if (item.hasClass('bg-fit-inside'))	{
				origImg.css({'width':newIWidth,	'height':newIHeight}); 
			} else {
			
					// OutSide Fitting
					if (item.hasClass('bg-fit-outside')) {
						
						origImg.css({'width':newOWidth,	'height':newOHeight});		    
					} else {
					
							// Stretch																		
							if (item.hasClass('bg-stretch')) {
								origImg.css({'width':$(window).width(),'height':$(window).height()});
							} else {
									// tiled																		
									if (item.hasClass('bg-tiled')) {
										  
										item.css({'width':($(window).width()+30)+"px",'height':$(window).height()});
										origImg.css({'width':($(window).width()+30)+"px",'height':$(window).height()});
									}
							}
					}
			}
		}	// END OF FUNCTION
	



//- END THE PLUGIN FROM HERE !!	
	}
})
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////////////////////
	// THE DROPDOWN PLUGIN STARTS HERE //
	////////////////////////////////////
	
	$.fn.extend({
	
		
		// OUR PLUGIN HERE :)
		dropdown: function(options) {
	
		
			
		////////////////////////////////
		// SET DEFAULT VALUES OF ITEM //
		////////////////////////////////
		var defaults = {	
			
		};
		
		options = $.extend({}, $.fn.dropdown.defaults, options);
		

		return this.each(function() {
		
			var opt=options;
			var dropdown=$(this);
			prepareLis(dropdown);	

			
		})
		
		
			
		
		//////////////////////		
		// SET THE LI ITEMS //
		/////////////////////
		function prepareLis(dd) {
		
			if ($.browser.msie && $.browser.version < 9) { 										
				dd.find('ul:first').css({'margin':'0px'});
			}
			// FIRST WRAP SOME DIV AROUND THE LI ITEMS, AND MAKE THEM READY FOR SMALL TRANSITIONS
			dd.find('li').each(function(i) {
				var $this=$(this);
				
				$this.wrapInner('<div class="listitem" style="position:relative;left:0px;"></div>');
				if ($.browser.msie && $.browser.version < 9) {											
					if (i==0) 	$this.css({'clear':'both','margin-top':'0px','padding-top':'0px'});					
															
					$this.css({'display':'none',
							   'opacity':'0.0',
							   'vertical-align':'bottom',							   							   
							   'top':'-20px'});		
					if ($.browser.msie && $.browser.version < 8) { 										
						$this.css({'width':$this.parent().parent().find('.buttonlight').width()});
						
					}
				} else {
				
					$this.css({'display':'none',
							   'opacity':'0.0',
							   'top':'-20px'});							   
				}
			});
			
			
			
						
			// HOVER ON THE UL SHOULD SHOW THE LI ITEMS, IF LIS ARE VISIBLE ALREADY, OTHER WAY HIDE IT AFTER 100 MS
			dd.hover(
				function() {
					var $this=$(this);											
					// CREATE A SETTIMEOUT TO MAKE SURE IT NOT START DIRECTYL
					clearTimeout($this.data('timeout'));
					var $this=$(this);
								
					$this.parent().find('li').each(function(i) {
							var $this=$(this);
							$this.css({'display':'block'});
							clearTimeout($this.data('lianim'));
							if ($.browser.msie && $.browser.version < 9) {	
								setTimeout(function(){$this.cssAnimate({'top':'0px','opacity':'1.0'},{duration:10});},(i+1*2));						
							} else {
								setTimeout(function(){$this.cssAnimate({'top':'0px','opacity':'1.0'},{duration:300});},(i+1*80));						
							}
						});	
																			
				},
				function() {
					var $this=$(this);

					// CREATE A SETTIMEOUT TO MAKE SURE IT NOT START DIRECTYL
					clearTimeout($this.data('timeout'));
					$this.data('timeout',setTimeout( function() {
						$this.find('li').each(function(i) {
							var $this=$(this);					
							if ($.browser.msie && $.browser.version < 9) {	
								$this.cssAnimate({'top':'-20px','opacity':'0.0'},{duration:0});
								$this.data('lianim',setTimeout(function(){$this.css({'display':'none'})},10));
							} else {
								$this.cssAnimate({'top':'-20px','opacity':'0.0'},{duration:300});
								$this.data('lianim',setTimeout(function(){$this.css({'display':'none'})},400));							
							}
						});
					},300));
					

				}
			);			
		}	// END OF prepareLis FUNCTION 
		
		
	}
})




	
	
	
	//////////////////////////////////////
	// THE LIGHTBOX PLUGIN STARTS HERE //
	/////////////////////////////////////
	
	$.fn.extend({
	
		
		// OUR PLUGIN HERE :)
		tplightbox: function(options) {
	
		
			
		////////////////////////////////
		// SET DEFAULT VALUES OF ITEM //
		////////////////////////////////
		var defaults = {	
			title:".entry-title",
			description:".entry-description",
			image:".image",
			style:"dark-lightbox",
			pageOfFormat:"Page #n of #m:",
			howGoogle:"yes",
			showFB:"yes",
			showTwitter:"yes",
			urlDivider:"?"
		};
		
		options = $.extend({}, $.fn.tplightbox.defaults, options);
		

		return this.each(function() {
		
			
			var opt=options;			
			var item=$(this);
			item.find('.hover-more-sign').click(function() {				
				startLightBox(item,opt);
			});
			
			
			
		
			
		})
		
		
			
			
			
		
		//////////////////////		
		// SET THE LI ITEMS //
		/////////////////////
		
		function checkiPhone() {
						var iPhone=((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)));
						return iPhone;
					}

					function checkiPad() {
						var iPad=navigator.userAgent.match(/iPad/i);
						return iPad;
					}
					

					
					
					
							
		/////////////////////////////////////////
		// START THE LIGHTBOX HERE AFTER CLICK //
		////////////////////////////////////////
		function addNewLightBoxItem(item,opt,direction) {
			
			
				var imgsrc = item.find(opt.image).data('src');
			var imgtyp = item.find(opt.image).data('typ');
			$('body').append('<div id="tp-lightboxactitem" class="'+opt.style+' lightboxitem"></div>');
			
			// ADD THE IMAGE TO THE HOLDER
			var lboxitem = $('body').find('#tp-lightboxactitem');

			if (imgtyp=="video") {
				var ww= item.find(opt.image).data('width');
				var hh= item.find(opt.image).data('height');
				var flvid="flv-"+Math.floor(Math.random()*999999);
				lboxitem.append('<div class="tp-mainimage" id="'+flvid+'" style="width:'+ww+'px;height:'+hh+'px">'+imgsrc+'</div>');
				
								
				if (item.find(opt.image).data('flv')===true) {
					var flvitem = lboxitem.find('#'+flvid+" a");
					flvid=flvitem.attr('id');
					flvitem.addClass("flvvideo");
					flowplayer(flvid,item.find(opt.image).data('flvplayer'),{clip: {autoPlay: false, autoBuffering: true}});
				}
			} else if (imgtyp=="video-mp4") {
                var timestampId = 'video_js_load' + new Date().getTime();
                var ww= item.find(opt.image).data('width');
                var hh= item.find(opt.image).data('height');
                lboxitem.append('<div class="tp-mainimage" style="width:'+ww+'px;height:'+hh+'px">' +
                    '<video id="'+timestampId+'" controls preload="auto"  class="video-js vjs-default-skin" width="'+ww+'" height="'+hh+'" controls  data-setup=\'{"example_option":true}\'> ' +
                    '<source src="'+item.find(opt.image).data('mp4')+'" type="video/mp4">Your browser does not support the video tag.</video></div>');
                videojs(timestampId, {}, function(){
                    // Player (this) is initialized and ready.
                });
            } else {
				lboxitem.append('<div><img class="tp-mainimage" src="'+imgsrc+'"></div>');
			}


			
			lboxitem.css({'display':'none'});
							
			
			// ADD AN INFOFIELD TO THE LIGHTBOX
			lboxitem.append('<div class="'+opt.style+' infofield"></div>');
			var infofield=lboxitem.find('.infofield');
			
			//ADD THE TITLE TO THE HOLDER
			infofield.append('<div class="'+opt.style+' title">'+item.find(opt.title).html()+'</div>');
			
			
			
			//////////////////////////////
			//	SPEZIELL FOR PORTFOLIO  //
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				var maxitem=0;
				var loader = $('body').find('#tp-lightboxloader');
				var pagebutton = $('body').find('.buttonlight-selected');
				if (loader.data('list') == undefined) {
					
					var list=[];
					
					pagebutton.each(function() {
						var $this=$(this);
						
						for (var i=0;i<$this.data('list').length;i++) 
							
							list.push($this.data('list')[i]);
					});			
										
					loader.data('list',list);
				}
				
				var pagetext = opt.pageOfFormat;
				var actEntryNr =item.data('EntryNr');
																
                var goTopageNr = Math.floor((actEntryNr-1) / pagebutton.data('entryProPage'));
				
				if ((goTopageNr+1) != pagebutton.data('pageNr')) $('body').find('#pagebutton'+(goTopageNr)).click();
				
				
				
				lboxitem.data('EntryNr',actEntryNr);
				lboxitem.data('MaxEntry',loader.data('list').length);
				lboxitem.data('opt',opt);
				
				/*pagetext = pagetext.replace('#n',actEntryNr);
				pagetext = pagetext.replace('#m',loader.data('list').length);*/
				pagetext = "( "+actEntryNr+" / "+loader.data('list').length+" )";
				
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			
			// ADD THE N PAGE OF M PAGES DIV
			infofield.append('<div class="'+opt.style+' pageofformat">'+pagetext+'</div>');
			
			
			//ADD THE Description TO THE HOLDER
			infofield.append('<div class="'+opt.style+' description">'+item.find(opt.description).html()+'</div>');
			
			/////////////////////////////
			//	THE DEEP LINK FUNCTION //
			/////////////////////////////
			
			var filter=$('body').find(opt.filterList).find('.selected-filter-item').data("filterid");
			
			var urllink=document.URL+opt.urlDivider+"filter="+filter+"_id="+actEntryNr;
			//var urllink=document.URL;//+opt.urlDivider+"filter="+filter+"_id="+actEntryNr;
			
			// ADD THE SOCIAL ICONS
			var twit=$('<div class="twitter"><div class="social_tab"><a href="http://twitter.com/share" class="twitter-share-button" data-url="'+urllink+'" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></div>');											
			//var face=$('<div class="facebook"><div class="social_tab"><iframe src="//www.facebook.com/plugins/like.php?href='+urllink+'&amp;send=false&amp;layout=button_count&amp;width=250&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:21px;" allowTransparency="true"></iframe></div></div>');
			var face=$('<div class="facebook"><div class="social_tab"><iframe src="//www.facebook.com/plugins/like.php?href='+urllink+'&amp;send=false&amp;layout=button_count&amp;width=250&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:21px;" allowTransparency="true"></iframe></div></div>');
			var gplus=$('<div class="googleplus"><!-- +1 Button from plus.google.com --><div class="social_tab"><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><g:plusone size="medium" href="'+urllink+'"></g:plusone></div></div>');
					
			
			infofield.append('<div class="'+opt.style+' lightboxsocials"></div>');
			var soc=infofield.find('.lightboxsocials');
			soc.css({'opacity':'0.0'});
			soc.data('opt',opt);
			if (opt.showTwitter=="yes") {	
				soc.data('twit',twit);
				soc.append('<div class="twitter fakesoc"></div>');
			}
			if (opt.showFB=="yes") {
				soc.data('face',face);
				soc.append('<div class="twitter fakesoc"></div>');
			}
			if (opt.showGoogle=="yes") {
				soc.data('gplus',gplus);
				soc.append('<div class="twitter fakesoc"></div>');
			}
		
			
			//ADD THE BUTTONS
			lboxitem.append('<div class="'+opt.style+' leftbutton"></div>');
			lboxitem.append('<div class="'+opt.style+' rightbutton"></div>');
			lboxitem.append('<div class="'+opt.style+' closebutton"></div>');
			
			var cbutton = lboxitem.find('.closebutton');
			var lbutton = lboxitem.find('.leftbutton');
			var rbutton = lboxitem.find('.rightbutton');
			
			cbutton.css({'opacity':'0.0'});
			
			cbutton.click(function() {
							removeLightBox();
						});
						
			
			
			
			//SEARCH2
			
			
			lbutton.click(
				function() {				
					var item=$(this).parent();
					var entrynr=item.data('EntryNr');
					var maxentry=item.data('MaxEntry');
					var opt = item.data('opt');					
					if (entrynr>1) {
						var newitem=$('body').find('.buttonlight-selected').data('list')[entrynr-2].clone();
						newitem.data('EntryNr',entrynr-1);
					 } else  {						
						newitem=$('body').find('.buttonlight-selected').data('list')[maxentry-1].clone();
						newitem.data('EntryNr',maxentry);
						
					}
						
					$('body').append(newitem);
					newitem.attr('id',"notimportant");
                    
					lightBoxItemOut(2);					
					addNewLightBoxItem(newitem,opt,2);					
					
				});
			
			rbutton.click(
				function() {	
					
					var item=$(this).parent();
					var entrynr=item.data('EntryNr');
					var maxentry=item.data('MaxEntry');
					var opt = item.data('opt');					
					
					if (entrynr<maxentry) {
						var newitem=$('body').find('.buttonlight-selected').data('list')[entrynr].clone();
						newitem.data('EntryNr',entrynr+1);
					 } else  {						
						newitem=$('body').find('.buttonlight-selected').data('list')[0].clone();
						newitem.data('EntryNr',1);						
					}
						
					$('body').append(newitem);
					newitem.attr('id',"notimportant");
                    
					lightBoxItemOut(1);					
					addNewLightBoxItem(newitem,opt,1);					
					
				});
			
			
			// TOUCH ENABLED SCROLL
						
				lboxitem.swipe( {data:lboxitem, 
								swipeLeft:function() 
										{ 
											var lboxitem = $('body').find('#tp-lightboxactitem');
											lboxitem.find('.rightbutton').click();
											
										}, 
								swipeRight:function() 
										{
											var lboxitem = $('body').find('#tp-lightboxactitem');
											lboxitem.find('.leftbutton').click();
										}, 
							allowPageScroll:"auto"} );
									
									
			// WAIT TILL IMAGE IS LOADED, AND THAN SET POSITION, ANIMATION, ETC....
			lboxitem.waitForImages(function() {   		
					
					if (direction!=1 && direction!=2) direction=1;
					lightBoxItemIn(direction);
					
					lboxitem.addClass('tp-lightboxactitem-loaded');
				});
			$('body').find('#notimportant').remove();
		}
		
		
		////////////////////////////
		// FACEBOOK LIKE FUNCTION //
		////////////////////////////
		function startFaceBook(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1";
				fjs.parentNode.insertBefore(js, fjs);
			}
		
		////////////////////////////////
		// REMOVE LIGHTBOX FROM STAGE //
		////////////////////////////////
		function removeLightBox() {
						lightBoxItemOut(1);
						setTimeout(function() {
							$('body').find('#tp-lightboxoverlay').cssAnimate({'opacity':'0.0'},{duration:400,queue:false});
							$('body').find('#tp-lightboxloader').cssAnimate({'opacity':'0.0'},{duration:400,queue:false});							
						},200);
						setTimeout(function() {
							$('body').find('#tp-lightboxoverlay').remove();
							$('body').find('#tp-lightboxloader').remove();
							$('body').find('#tp-lightboxactitem').remove();
						},600);
		}
		
		
		//////////////////////////////////////
		// MOVE THE BIG IMAGE TO THE STAGE //
		//////////////////////////////////////
		function lightBoxItemIn(dir) {		// DIR 1:  <-      DIR2: ->   //
		
					var lboxitem = $('body').find('#tp-lightboxactitem');
					var loader = $('body').find('#tp-lightboxloader');
					var lbutton = lboxitem.find('.leftbutton');
					var rbutton = lboxitem.find('.rightbutton');
					var soc=lboxitem.find('.lightboxsocials');
					var infofield=lboxitem.find('.infofield');
					var mainimg = lboxitem.find('.tp-mainimage');
					
					clearTimeout(loader.data('anim'));
					loader.cssAnimate({'top':(($(window).height()/2)-60)+'px','opacity':'0.0'},{duration:200,queue:false});
					
					lboxitem.css({
							'top':'0px',
							'left':(60+$(window).width())+'px',
							'display':'block'
							});
					
					
					setTimeout(function() {
							var opt=soc.data('opt');
							if (opt.showTwitter=="yes") soc.append(soc.data('twit'));
							if (opt.showFB=="yes") {
								soc.append(soc.data('face'));
								//startFacebook(document, 'script', 'facebook-jssdk');
							}
							if (opt.showGoogle=="yes") soc.append(soc.data('gplus'));
							soc.find('.fakesoc').remove();
							soc.css({'display':'block','opacity':'0.0'});
							setTimeout(function() {soc.cssAnimate({'opacity':'1.0'},{duration:400,queue:false})},500);
					},700);
					
					
					
					
					var thisw = mainimg.width();
					var imgw = mainimg.width();
					
					
					var imgh = mainimg.height();
					
					if (thisw==0) { imgw=320; thisw=320;}
					if (imgh==0)  imgh = 200;
					
					var infoboxh = infofield.outerHeight();					
					lboxitem.css({'width':thisw+"px"});										
					var thish = imgh + infoboxh;
					var ww = $(window).width()-40;
					var wh = $(window).height()-40;
					
					// SET THE RIGHT START POSITION
					if (dir==2) lboxitem.css({'left':(-30-thisw)+'px','top':'0px'});
					
					lbutton.css({'left':'0px','top':imgh+'px'});
					rbutton.css({'right':'0px','top':imgh+'px'});					
					lboxitem.css({'top':($(window).height()/2 - thish/2)+'px'});
					
					// CHECK IF WIDTH & HEIGHT TOO BIG
					
					if (thisw>ww) {									
						var prop = ww /thisw;						
						thisw = ww;												
						imgh = prop * imgh;
						
					    mainimg.width(thisw);
					    mainimg.height(imgh);
					
						
						imgh = mainimg.height();
						infoboxh = infofield.outerHeight();					
						lboxitem.css({'width':thisw+"px"});										
						thish = imgh + infoboxh;
						lbutton.css({'left':'0px','top':imgh+'px'});
						rbutton.css({'right':'0px','top':imgh+'px'});					
						lboxitem.css({'top':($(window).height()/2 - thish/2)+'px'});
						if (lboxitem.find('iframe').length>0) {
							lboxitem.find('iframe').css({'width':thisw+"px",'height':imgh+"px"});
							
						}
					}
					
					
					if (thish>wh) {
						var prop = wh /thish;											
						imgw = prop * imgw;
						imgh = prop * imgh;
						
					    mainimg.width(imgw);
					    mainimg.height(imgh);
					
						if (imgw>300) thisw=imgw;
						imgh = mainimg.height();
						infoboxh = infofield.outerHeight();					
						lboxitem.css({'width':thisw+"px"});										
						thish = imgh + infoboxh;
						lbutton.css({'left':'0px','top':imgh+'px'});
						rbutton.css({'right':'0px','top':imgh+'px'});					
						lboxitem.css({'top':($(window).height()/2 - thish/2)+'px'});
						if (lboxitem.find('iframe').length>0) {
							lboxitem.find('iframe').css({'width':imgw+"px",'height':imgh+"px"});
							
						}
					}
															
					
					// 2nd Proof of Heig
					
					
					setTimeout(
						function() {
							
							var thisheight =lboxitem.height();
							lboxitem.css({'top':($(window).height()/2 - thisheight/2)+'px'});														
							lboxitem.cssAnimate({'left':($(window).width()/2 - thisw/2)+'px', 'top':($(window).height()/2 - thisheight/2)+'px'},{duration:300,queue:false});

							// Turn On Close Button Functions...
							lboxitem.hover(
								function() {
									var $this=$(this);
									$this.find('.closebutton').cssAnimate({'opacity':'1.0'},{duration:100,queue:false});
								}, 
								function() {
									var $this=$(this);
									$this.find('.closebutton').cssAnimate({'opacity':'0.0'},{duration:100,queue:false});
								});
							
						},200);
		}
		
		
		
		
		//////////////////////////////////////////
		// MOVE THE BIG IMAGE OUT OF THE STAGE //
		/////////////////////////////////////////
		function lightBoxItemOut(dir) {		// DIR 1:  <-      DIR2: ->   //
					
					var lboxitem = $('body').find('#tp-lightboxactitem');
					var loader = $('body').find('#tp-lightboxloader');
					var lbutton = lboxitem.find('.leftbutton');
					var rbutton = lboxitem.find('.rightbutton');
					
					try{
						lboxitem.find(".flvvideo").unload();
						lboxitem.find(".flvvideo").remove();
					} catch(e) {};
					
					lboxitem.attr('id',"tp-lightbox-OLD-item");
					var thisw = lboxitem.find('.tp-mainimage').width();
					
					loader.data('anim',setTimeout(function() {loader.cssAnimate({'top':(($(window).height()/2))+'px','opacity':'1.0'},{duration:200,queue:false});},400));									
					if (dir==1)
						setTimeout(function() {lboxitem.cssAnimate({'left':(-50 - thisw)+'px'},{duration:300,queue:false});},150);
					else 
						setTimeout(function() {lboxitem.cssAnimate({'left':(50+$(window).width())+'px'},{duration:300,queue:false});},150);
					
					setTimeout(function() {lboxitem.remove()},450);
		}
		
		
		
		/////////////////////////////////////////
		// START THE LIGHTBOX HERE AFTER CLICK //
		////////////////////////////////////////
		function startLightBox(item,opt) {
						
						// ADD A BIG OVERLAY ON THE SCREEN
					    
						
						$('body').append('<div id="tp-lightboxoverlay" class="'+opt.style+' overlay"></div>');
						var overlay=$('body').find('#tp-lightboxoverlay');
						
						var targetOpacity = overlay.css('opacity');
						
						// LIGHTBOX PROBLEM FOR iPAD && iPhone
						var ts=0;
						if (checkiPhone() || checkiPad()) ts=jQuery(window).scrollTop();
						
						overlay.css({	
										'width':$(window).width()+'px',
										'height':($(window).height()+150)+'px',
										'opacity':'0.4',
										'top':'0px',
										'left':'0px'
										});																	

						overlay.cssAnimate({'opacity':targetOpacity},{duration:500,queue:false});
						
						$('body').append('<div id="tp-lightboxloader" class="'+opt.style+' loader"></div>');
						var loader=$('body').find('#tp-lightboxloader');
						loader.css({
										'top':(ts+$(window).height()/2)+'px',
										'left':$(window).width()/2+'px'});
						
						
						addNewLightBoxItem(item,opt);
						
						overlay.click(function() {
							removeLightBox();
						});
						
						/////////////////////////////////////////////////////////////////////////////////////
						// DEPENDING ON THE SCROLL OR RESIZING EFFECT, WE SHOULD REPOSITION THE LIGHTBOX  //
						/////////////////////////////////////////////////////////////////////////////////////
						$(window).bind('resize scroll', resizeMeNow);						
		}
		
		
		
				/////////////////////////////////////////////////////
				// RESIZE THE WINDOW, AND OPEN THE MAIN IMAGE HERE //
				/////////////////////////////////////////////////////
				function resizeMeNow(dontshowinfo) {
						
						var $this=$(window);							
						var overlay=$('body').find('#tp-lightboxoverlay');
						
						
						// LIGHTBOX PROBLEM FOR iPAD && iPhone
						var ts=0;
						if (checkiPhone() || checkiPad()) ts=jQuery(window).scrollTop();
						
						overlay.css({'width':$this.width()+'px',
									'height':($this.height()+150)+'px',
									'top':ts+'px'
									});
						
						// SET THE LOADER POSITION IN THE RIGHT POSITION
						var loader=$('body').find('#tp-lightboxloader');
						loader.cssAnimate({
										'top':(ts+$(window).height()/2)+'px',
										'left':$(window).width()/2+'px'}, {duration:200,queue:false});
						
						// SET THE ACTUAL SHOWN MAIN ITEM POSITION
						var thisw=$('body').find('.tp-lightboxactitem-loaded').width();
						var thish=$('body').find('.tp-lightboxactitem-loaded').height();						
						$('body').find('.tp-lightboxactitem-loaded').cssAnimate({'left':($(window).width()/2 - thisw/2)+'px', 'top':($(window).height()/2 - thish/2)+'px' },{duration:300,queue:false});
						
					}
					
				
				//////////////////////////////////////
				// GET THE PAGESCROLL SETTINGS HERE //
				//////////////////////////////////////
				function getPageScroll() {
					var  yScroll;
					if (self.pageYOffset) {
					  yScroll = self.pageYOffset;
					  
					} else if (document.documentElement && document.documentElement.scrollTop) {
					  yScroll = document.documentElement.scrollTop;
					  
					} else if (document.body) {// all other Explorers
					  yScroll = document.body.scrollTop;
					  
					}
					return yScroll;
				}
					
		
			
						
		
		
	}
})



	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	///////////////////////////////////////
	// THE PORTFOLIO PLUGIN STARTS HERE //
	//////////////////////////////////////
	
	$.fn.extend({
	
		
		// OUR PLUGIN HERE :)
		portfolio: function(options) {
	
		
			
		////////////////////////////////
		// SET DEFAULT VALUES OF ITEM //
		////////////////////////////////
		var defaults = {	
		 
			gridOffset:0,
			cellWidth:176,
			cellHeight:176,
			cellPadding:10,
			gridOffset:0,
			captionOpacity:75,
			entryProPage:20,
			filterList:"#portfolio-filter",
			pageOfFormat:"#n of #m",
			title:"#selected-filter-title",
			showGoogle:"yes",
			showFB:"yes",
			showTwitter:"yes",
			urlDivider:"?",
			backgroundHolder:"#main-background",
			backgroundSlideshow:0
		};
		
		options = $.extend({}, $.fn.portfolio.defaults, options);
					
		
		return this.each(function() {
					
			//PUT THE BANNER HOLDER IN A VARIABLE
			var grid = $(this);
			var opt=options;
			
			// SET DEFAULT SIZES
			grid.data('cellWidth',opt.cellWidth);
			grid.data('cellHeight',opt.cellHeight); 
			grid.data('padding',opt.cellPadding);
			grid.data('gridOffset',opt.gridOffset);	
			grid.data('gridOffset',opt.gridOffset);
			grid.data('captionOpacity',opt.captionOpacity);
			
			//ALIGN THE CELLS FIRST TIME
			alignCells(grid);
			
			//CHANGE ON RESIZING IT
			resizeHandler(grid);
			prepareCaptions(grid,opt);
			
			$('body').find(opt.filterList).dropdown({});	
			prepareFilters(grid,opt);
			
		
			
			//BACKGROUND STARTER			
			$('body').find(opt.backgroundHolder).tpbackground({
						slideshow:opt.backgroundSlideshow,
						callback:"false",
						cat:""
						
					});	
			
			//grid swipe....
				grid.swipe( {data:grid, 
								swipeLeft:function() 
										{ 
											var id=parseInt($('body').find('.buttonlight-selected').data('pageNr'),0);
											var maxid = $('body').find('#pagination .buttonlight').length;
											if (id<maxid) 
												$('body').find('#pagebutton'+id).click()
											 else
												$('body').find('#pagebutton0').click()
											
										}, 
								swipeRight:function() 
										{
											var id=parseInt($('body').find('.buttonlight-selected').data('pageNr'),0);
											var maxid = $('body').find('#pagination .buttonlight').length;
											
											if (id>1) 
												$('body').find('#pagebutton'+(id-2)).click()
											 else
												$('body').find('#pagebutton'+(maxid-1)).click()					
										}, 
							allowPageScroll:"auto"} );
									
		})
	}
})

		///////////////////////////
		// GET THE URL PARAMETER //
		///////////////////////////
		function getUrlVars(hashdivider)
				{
					var vars = [], hash;
					var hashes = window.location.href.slice(window.location.href.indexOf(hashdivider) + 1).split('_');
					for(var i = 0; i < hashes.length; i++)
					{
						hashes[i] = hashes[i].replace('%3D',"=");
						hash = hashes[i].split('=');
						vars.push(hash[0]);
						vars[hash[0]] = hash[1];
					}
					return vars;
				}
						
						
						
						
						
		///////////////////////////////////////////////////
		//	PREPARE THE FILTERS AND SAVE THE HTML INFOS //
		///////////////////////////////////////////////////
		function prepareFilters(grid,opt) {
		
			// SELECT ALL THE ITEMS FROM THE PORTFOLIO
			var all=[];
			grid.find('>div').each(function() {
				var $this=$(this);
				all.push($this);
			});			
			
			grid.data('all',all);									
			
			// LETS SELECT ALL DIV OBJECTS PER FILTER ITEMS
			$('body').find(opt.filterList+' ul li').each(function(i) {				
				
				var $li=$(this);
				if (i==0) $li.addClass('selected-filter-item');
				$li.data('filterid',i);
				var list=[];	
			
				grid.find("."+$li.data('category')).each(function() {				
					var $div=$(this);				
					list.push($div.clone());
				});
				
				// ADD ALL ELEMENT IN THE ARRAY
				$li.data('list',list);
				
				// IF FILTER HAS BEEN CLICKED, WE CAN REMOVE, AND REPLEACE THE ITEMS.
				$li.click(function() {
					var $this=$(this);
					$this.closest('ul').find('>li').each(function() {
						var $this=$(this);
						$this.removeClass("selected-filter-item");
					});
					
					$this.addClass("selected-filter-item");
					
					pagination(grid,$this.data('list'),1,opt);
					
					$('body').find(opt.title).cssAnimate({'opacity':'0.0'},{duration:500,queue:false});
					setTimeout(function() {
						
						//BACKGROUND Changer
						$('body').find(opt.backgroundHolder).tpbackground({
									slideshow:opt.backgroundSlideshow,
									callback:"true",
									cat:$this.data('category')								
								});	
						
						$('body').find(opt.title).html($this.html());
						$('body').find(opt.title).cssAnimate({'opacity':'1.0'},{duration:500,queue:false});
					},500);
				});				
			});						
			//pagination(grid,grid.data('all'),1,opt);
			
			
			
			/////////////////////////////
			//	THE DEEP LINK FUNCTION //
			/////////////////////////////
			
			
			// Check URL and if filter is set, let choose the right Item direct ! 
			var selected = getUrlVars(opt.urlDivider)["filter"];
			var id =getUrlVars(opt.urlDivider)["id"];
			opt.selectedid=id;
			
			
			
			if (selected!=null) {
				$('body').find(opt.filterList+' ul li').each(function() 	{
					var $this=$(this);
					
					
					if ($this.index()==decodeURI(selected)) {
						
						$('body').find(opt.filterList).find('.selected-filter-item').removeClass('selected-filter-item');
						$this.addClass('selected-filter-item');
					}					
				});
			}
			
			$('body').find(opt.filterList).find('.selected-filter-item').click();
			
			
			// IF ID IS SET, WE NEED ALSO THE LIGHTBOX START
			if (id!=null)  {
				setTimeout(function() {
									
			   		    var newitem=$('body').find('.buttonlight-selected').data('list')[((parseInt(id,0))-1)].clone();
						newitem.data('EntryNr',parseInt(id,0));	
						$('body').append(newitem);		
						newitem.attr('id',"notimportant");
						newitem.css({'display':'none'});
						setLightboxClick(newitem,opt);																				
						
						$('body').find('#notimportant .hover-more-sign').click();
						
				},500);
			}
		}
		
		
		
		
		
		// HERE
		//////////////////////////////////////
		// THE THUMBNAIL BW and COLOR IMAGE //
		//////////////////////////////////////
		function addThumbnailImages(item) {
			var src=item.data('mainthumb');
			var srcbw=item.data('bwthumb');
			var srctype=item.data('type');
                        switch(srctype) {
                        case 'youtube':
                            if (!item.find('iframe').hasClass("normal-thumbnail-yoyo"))
                                    item.append(src);                               
                        break;
                        case 'vimeo':
                            if (!item.find('iframe').hasClass("normal-thumbnail-yoyo"))
                                    item.append(src);                               
                        break;
                        default:
//                            if (!item.find('img').hasClass("bw-thumbnail-yoyo"))
//                                    item.append('<img class="bw-thumbnail-yoyo" src="'+srcbw+'">');
                            if (!item.find('img').hasClass("normal-thumbnail-yoyo"))
                                    item.append('<img class="normal-thumbnail-yoyo" src="'+src+'">');                            
                        }
                        

			
			
		}
		
		
		
		////////////////////////////////////////////////////////////
		// SET THE ROLL OVER AND ROLL OUT FUNCTIONS ON THUMBNAILS //
		////////////////////////////////////////////////////////////
		function setRollOver(item) {
			var plus=null;
			var blog=null;
			
			
			
			if (item.find('.entry-info').length>0) {
				if (!item.find("div").hasClass('hover-more-sign'))
					item.append('<div class="hover-more-sign"></div>');
				plus=item.find('.hover-more-sign');
			}
			
			if (item.find('.blog-link').length>0) {
				var newlink = item.find('.blog-link');				
				newlink.removeClass('.blog-link');
				newlink.addClass("hover-blog-link-sign");
				if (!item.find("div").hasClass('hover-blog-link-sign'))
					item.append(newlink);
				blog=item.find('.hover-blog-link-sign');
				
				/*blog.click(function() {
					alert("KK");
				});*/
			}
			
			if (plus!=null && blog==null) {		
				plus.css({'left':(parseInt(item.width()/2,0)-25)+"px",'top':(parseInt(item.height()/2,0)+60)+"px",'display':'none','opacity':'0.0'});
			 } else {
				if (plus==null && blog!=null) {
					blog.css({'left':(parseInt(item.width()/2,0)-25)+"px",'top':(parseInt(item.height()/2,0)+60)+"px",'display':'none','opacity':'0.0'});			   
			 } else {
					plus.css({'left':(parseInt(item.width()/2,0)-50)+"px",'top':(parseInt(item.height()/2,0)+60)+"px",'display':'none','opacity':'0.0'});			
					blog.css({'left':(parseInt(item.width()/2,0)+10)+"px",'top':(parseInt(item.height()/2,0)+60)+"px",'display':'none','opacity':'0.0'});			   					
			}}
			
			item.hover(
			
				///////////////////////////////////
				// ROLL OVER OF AN IMAGE ITEM   //
				///////////////////////////////////
				function() {
				
						var $this=$(this);
						var mainthumb=$this.find('.normal-thumbnail-yoyo');
						
						var plus=$this.find('.hover-more-sign');
						var blog=$this.find('.hover-blog-link-sign');
						
						var caption=$this.find('.caption');
						if (caption.data('top')==undefined) caption.data('top',parseInt(caption.css('top'),0));
						
						clearTimeout($this.data('plusanim'));
						clearTimeout($this.data('capanim'));
						clearTimeout($this.data('bwpanim'));
						clearTimeout($('body').find('.theBigThemePunchGallery').data('bwanim'));
						
						$this.data('plusanim',
							setTimeout(
								function() {
									plus.css({'display':'block'});
									plus.cssAnimate({'top':(parseInt($this.height()/2,0)-25)+'px','opacity':'1.0'},{duration:300,queue:false})
									
									blog.css({'display':'block'});
									setTimeout(function() {
										blog.cssAnimate({'top':(parseInt($this.height()/2,0)-25)+'px','opacity':'1.0'},{duration:300,queue:false})
										},100);
								},10));
						$this.data('capanim',								
							setTimeout(
								function() {
									caption.data('opa',caption.css('opacity'));
									caption.cssAnimate({'top':(caption.data('top')-60)+'px','opacity':'0.0'},{duration:200,queue:false})
								},100));
						
						$('body').find('.theBigThemePunchGallery').data('bwanim',
							setTimeout(
								function() {
									$('body').find('.theBigThemePunchGallery').each(function() {
										var $this=$(this);
										$this.find('.normal-thumbnail-yoyo').cssAnimate({'opacity':'0.3'},{duration:500});
									});
								},100));
						
						$this.data('bwanim',								
							setTimeout(
								function() {
									mainthumb.cssAnimate({'opacity':'1.0'},{duration:200,queue:false})
								},210));
					
				} ,
				
				
				/////////////////////////////////
				// ROLL OUT OF AN IMAGE ITEM   //
				/////////////////////////////////
				function() {
						var $this=$(this);
						var mainthumb=$this.find('.normal-thumbnail-yoyo');
						
						var plus=$this.find('.hover-more-sign');
						var blog=$this.find('.hover-blog-link-sign');
						var caption=$this.find('.caption');
						if (caption.data('top')==undefined) caption.data('top',parseInt(caption.css('top'),0));
						
						clearTimeout($this.data('plusanim'));
						clearTimeout($this.data('capanim'));
						clearTimeout($this.data('bwanim'));
						clearTimeout($('body').find('.theBigThemePunchGallery').data('bwanim'));
						
						$this.data('plusanim',
							setTimeout(
								function() {
									plus.css({'display':'block'});
									plus.cssAnimate({'top':(parseInt($this.height()/2,0)+60)+'px','opacity':'0.0'},{duration:300,queue:false})
									
									blog.css({'display':'block'});
									setTimeout(function() {
										blog.cssAnimate({'top':(parseInt($this.height()/2,0)+60)+'px','opacity':'0.0'},{duration:300,queue:false})
									},100);
								},10));
						$this.data('capanim',								
							setTimeout(
								function() {
									
									caption.cssAnimate({'top':(caption.data('top'))+'px','opacity':caption.data('opa')},{duration:200,queue:false})
								},100));
						
						$('body').find('.theBigThemePunchGallery').data('bwanim',
							setTimeout(
								function() {
									$('body').find('.theBigThemePunchGallery').each(function() {
										var $this=$(this);
										$this.find('.normal-thumbnail-yoyo').cssAnimate({'opacity':'1.0'},{duration:200});
									});
								},100));
								
						$this.data('bwanim',								
							setTimeout(
								function() {
									mainthumb.cssAnimate({'opacity':'1.0'},{duration:200,queue:false})
								},100));
				});
		}
		
		
		
		/////////////////////////////////
		// CLICK ON THUMBNAIL HAPPENED //
		/////////////////////////////////
		function setLightboxClick(item,opt) {			
					item.tplightbox({
						title:".entry-title",
						description:".entry-description",
						image:".media",
						style:"dark-lightbox",
						pageOfFormat:opt.pageOfFormat,
						showGoogle:opt.showGoogle, 
						showFB:opt.showFB,
						showEmail:opt.showEmail,
						emailLinkText:opt.emailLinkText,
						emailBody:opt.emailBody,						
						emailUrlCustomPrefix:opt.emailUrlCustomPrefix,
						emailUrlCustomSuffix:opt.emailUrlCustomSuffix,
						showTwitter:opt.showTwitter,
						urlDivider:opt.urlDivider,
						filterList:opt.filterList
					});
					
		}
		
		
		
		
		
		
		
		
		///////////////////////////////////
		// THE PAGINATION YO YO FUNCTION //
		///////////////////////////////////
		function pagination(grid,theList,pageNr,opt) {
						grid.find('>div').remove();				
						// ADD SOME SPEC CLASS, SO WE CAN FIND THE GRID AGAIN ! 
						if (!grid.hasClass('theBigThemePunchGallery')) grid.addClass('theBigThemePunchGallery');
						
						for (var j=0;j<theList.length;j++) {
							if (j>=(pageNr-1)*opt.entryProPage && j<(opt.entryProPage*pageNr)) {
								var newelement=theList[j];																	
								grid.append(newelement);						
								newelement.css({'opacity':'0','left':"0px",'top':'0px'});
								newelement.data('EntryNr',(j+1));
								addThumbnailImages(newelement.find('.thumbnails'));								
								
								if (newelement.find('.entry-info').length>0 || newelement.find('.blog-link').length>0)
									setRollOver(newelement);								
								
								if (newelement.find('.entry-info').length>0) {
									setLightboxClick(newelement,opt);									
								}
							}							
						}
						alignCells(grid,true);
						
						// CALCULATE THE AMOUNT OF THE PAGES						
						var page=Math.ceil(theList.length/opt.entryProPage);						
						grid.parent().find('#pagination').remove();	

						
                        // IF THERE IS MORE THAN ONE PAGE 	
						
						if (page>1) {
							
							// SET THE TEXT FORMAT BEFORE THE BUTTONS
							var pageof = opt.pageOfFormat;
							pageof = pageof.replace('#n',pageNr);
							pageof = pageof.replace('#m',page);
							
							// ADD THE CONTAINER 
							grid.parent().append('<div style="" class="pagination" id="pagination"><div class="pageofformat">'+pageof+'</div></div>');						
							var pagin=grid.parent().find('#pagination');							
							
							// CREATE THE PAGE BUTTONS HERE
							for (var i=0;i<page;i++) {
								pagin.append('<div id="pagebutton'+i+'"class="pages buttonlight">'+(i+1)+'</div>');
								var butt=pagin.find("#pagebutton"+i);
								if (i+1==pageNr) butt.addClass("buttonlight-selected");
								butt.data('pageNr',(i+1));
								butt.data('entryProPage',opt.entryProPage);
								butt.data('list',theList);
								butt.click(function() {
									var $this=$(this);
									pagination(grid,$this.data('list'),$this.data('pageNr'),opt);
								});
							}
						} else {
								grid.parent().append('<div style="display:none" class="pagination" id="pagination"><div class="pageofformat">'+pageof+'</div></div>');						
								var pagin=grid.parent().find('#pagination');							
								pagin.append('<div style="display:none" id="pagebutton" class="pages buttonlight"></div>');
								
								var butt=pagin.find("#pagebutton");
								butt.addClass("buttonlight-selected");
								
								butt.data('pageNr',1);
								butt.data('entryProPage',opt.entryProPage);
								
								butt.data('list',theList);
						
						}
						
						
					}
					
					
					
					
					
					
					
		///////////////////////////////
		//  --  LOCALE FUNCTIONS -- //
		///////////////////////////////
		
		function prepareCaptions(grid,opt) {
				grid.find('.caption').each(function() {												
						var $this=$(this);
						var pw=$this.parent().width();
						
						var phor = parseInt($this.css('paddingLeft'),0) +  parseInt($this.css('paddingRight'),0)
						var pver = parseInt($this.css('paddingTop'),0) +  parseInt($this.css('paddingBottom'),0)
						
						pw=pw-phor;
						
						if ($this.width()>pw-20) {							
							$this.css({'position':'absolute','left':'10px','width':(pw-20)+"px"});							
						} else {
							$this.css({'left':((pw)/2 - $this.width()/2)+"px"})
						}
						
						var ph=$this.parent().height();
						ph=ph-pver;					
						$this.data('opa',parseInt(grid.data('captionOpacity'),0)/100);
						
						var dif=0;
						
						if (opt.captionYOffset!=undefined) dif=opt.captionYOffset;
						
						if (opt.captionPosition=="top")
							
							$this.css({'opacity':$this.data('opa'), 'top':(0+dif)+"px"})
						else 
							if (opt.captionPosition=="bottom")
								$this.css({'opacity':$this.data('opa'), 'top':((ph) - $this.height()+dif)+"px"})
							else
								$this.css({'opacity':$this.data('opa'), 'top':(dif + (ph)/2 - $this.height()/2)+"px"})
								
								
						$this.css({'visibility':'visible'});
					});
		}
		
		
		///////////////////////////////////
		// LISTEN ON RESIZING THE WINDOW //
		///////////////////////////////////
		function resizeHandler(grid){
			 $(window).bind('resize', function() {
				 if (grid.data('windowWidth') != $(window).width()) {
					 alignCells(grid,false);
					 grid.data('windowWidth',$(window).width());;
				 }
			 });
		}
		
		//////////////////////////////////////////////
		// SET THE COL AND ROW POSITION OF THE CELL //
		//////////////////////////////////////////////
		function setUsed(usedCells, col, row) {
			var index = usedCells.length;        
			usedCells[index] = { left: col, top: row};
			
		}
		
		////////////////////////////////////////////
		// CHECK IF ALL CELLS HAS BEEN POSITIONED //
		///////////////////////////////////////////
		function isUsed(usedCells, col, row) {
				for (var i = 0; i < usedCells.length; i++) {
					
					if (usedCells[i].left === col &&
						usedCells[i].top === row) {
						return true;
					}
				}       
				return false;
				
		}
		
		/////////////////////////////////////////
		// PUT THE CELLS IN THE RIGHT POSITION //
		////////////////////////////////////////
		function styleCell(cell, x, y, cellWidth, cellHeight,i,pagination) {
					cell.css({width: cellWidth + "px",height: cellHeight + "px",position: "absolute"})
					cell.stop();
					
					if (pagination){					
						cell.cssAnimate({left:x+"px", opacity:0.0, top: (y+20) + "px"}, {duration:1 , queue:false});										
						if ($.browser.msie && $.browser.version < 9) {
							cell.css({'visibility':'hidden'});
						}						
					}
					setTimeout(function() {
							cell.css({'visibility':'visible'});
							cell.cssAnimate({opacity:1.0, left: x + "px",top: y + "px"}, {duration:350 , queue:false});
						},100+(i*50));	
					if (cell.parent().parent().data('ymax')<y+cellHeight)
						cell.parent().parent().data('ymax',y+cellHeight);
		}	
		
		
		////////////////////////////////////////////
		// REORGANISE THE CELLS IN NEW POSITIONS  //
		///////////////////////////////////////////
		function alignCells(grid,pagination) {
							// pagination -> do we need to reorganise the images, or just re position them ? true: load all images new...
							
							var cellWidth=grid.data('cellWidth');
							var cellHeight=grid.data('cellHeight');
							var padding=grid.data('padding');
							var gridOffset=grid.data('gridOffset');
							var maxRow=grid.data('maxRow');
							
							var x = 0;
							var y = 0;
							var count = 1;
							
							/* 
							 * When we add a "bigcell" to the grid it takes up four cells instead of one. 
							 * That makes we need to not add any other cells to those areas or the cells 
							 * will overlap.  These three variables are used to remember the cells used 
							 * by big cells. 
							 */
							var curCol = 0;
							var curRow = 0;
							var usedCells = [];
							
							grid.each(function() {

								var $this=$(this);
								var hasTallCell = false;
								
								var WW = $this.width() - parseInt(grid.data('gridOffset'),0);
								// The MAX cols Number
								var cols = Math.floor(WW / cellWidth);
								
								//$('body').find('.demo').remove();
								//$('body').append('<div style="position:absolute;top:10px;left:10px" class="demo">'+$this.width()+"   "+WW+"  "+parseInt(grid.data('gridOffset'),0)+'</div>');
								
								
								
								$this.css("position", "relative");
								
								var children = $this.children("div");
								
								$this.parent().data('ymax',0);
								
								//////////////////////////////////////////////////////
								// GO THROUGH ALL THE CELLS AND SET THEIR POSITION //
								//////////////////////////////////////////////////////
								for (var i = 0; i < children.length; i++) {
								
								
												/////////////////////////////////////
												// THE 2 x 2 CELL FORMAT HANDLING //
												/////////////////////////////////////
														if (children.eq(i).hasClass("cell2x2")) {
															if (curCol === cols - 1) {
																curCol = 0;
																curRow++;
																x = 0;
																y += cellHeight + padding;
																count++;											
															}
															// CHACK AROUND THE 2x2 CELL
															if (cols > 1 && (isUsed(usedCells, curCol, curRow) ||
																isUsed(usedCells, curCol + 1, curRow) ||
																isUsed(usedCells, curCol + 1, curRow + 1) ||
																isUsed(usedCells, curCol, curRow + 1))) {											
																i--;
															} else {																						
																styleCell(children.eq(i), x, y, (cellWidth * 2) + padding, (cellHeight * 2) + padding,i,pagination);
																setUsed(usedCells, curCol, curRow); 
																setUsed(usedCells, curCol + 1, curRow);
																setUsed(usedCells, curCol, curRow + 1);  
																setUsed(usedCells, curCol + 1, curRow + 1); 
															}
															// 2 HEIGHT CELL IS ADDED HERE
															hasTallCell = true;

													
															/////////////////////////////////////
															// THE 2 x 1 CELL FORMAT HANDLING //
															/////////////////////////////////////
																} else if (children.eq(i).hasClass("cell2x1")) {
																	if (isUsed(usedCells, curCol, curRow) ||
																		isUsed(usedCells, curCol + 1, curRow) ||
																		(cols > 1 && curCol === cols - 1)) {
																		
																		i--;
																		
																	} else {
																		styleCell(children.eq(i), x, y, (cellWidth * 2) + padding, cellHeight,i,pagination);
																		setUsed(usedCells, curCol + 1, curRow);
																	}
																
																		/////////////////////////////////////
																		// THE 1 x 2 CELL FORMAT HANDLING //
																		/////////////////////////////////////	
																			} else if (children.eq(i).hasClass("cell1x2")) {
																				if (isUsed(usedCells, curCol, curRow) ||
																					isUsed(usedCells, curCol, curRow + 1)) {											
																					i--;
																					
																				} else {
																					styleCell(children.eq(i), x, y, cellWidth, (cellHeight * 2) + padding,i,pagination);																						
																					setUsed(usedCells, curCol, curRow); 
																					setUsed(usedCells, curCol, curRow + 1);
																				}
																				
																				hasTallCell = true;

																					/////////////////////////////////////
																					// THE 1 x 1 CELL FORMAT HANDLING //
																					/////////////////////////////////////										
																						} else {
																							
																							if (isUsed(usedCells, curCol, curRow)) {
																								
																								i--;
																								
																							} else {
																								styleCell(children.eq(i), x, y, cellWidth, cellHeight,i,pagination);
																							}
																						}
												
												//////////////////////////////
												// NEW ROW, OR NEXT COL ?? //
												//////////////////////////////
												
												
												
												
												if ((count % cols) === 0) {										
													curCol = 0;
													curRow++;
													x = 0;
													y += cellHeight + padding;
													hasTallCell = false;
												} else {
													x += cellWidth + padding;
													curCol++;
												}
												
												count++;
									
								}
								
								
								//////////////////////////////////
								// Set the height of the Grid  //
								//////////////////////////////////
								var height = 0;
								
									if ((count % cols) !== 1) {
										height = y + cellHeight + padding;
									} else {
										height = y + padding;
									}
									
									if (hasTallCell) {
										height += cellHeight + padding;
									}
								
								 
								$(this).parent().css('height', $this.parent().data('ymax') + "px");
								
								
								//RESET VARIABLES FOR NEXT GRID
								x = 0;
								y = 0;
								count = 1;		

								var maxx=0;
								
								for (i = 0; i < children.length; i++) {
									
									//alert(children.eq(i).position().left);
									//if (maxx<children.eq(i).position().left+children.eq(i).width()) maxx=children.eq(i).position().left+children.eq(i).width();
									
								}
									//alert(maxx);								
							});
								
								
						}
		
				
})(jQuery);			

				
			

			   