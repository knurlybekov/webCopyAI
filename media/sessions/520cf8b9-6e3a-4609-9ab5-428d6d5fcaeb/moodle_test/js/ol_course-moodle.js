window.addEventListener('load', function () {
	
	//$("head link[rel='stylesheet']").last().after("<link rel='stylesheet' href='https://www.tru.ca/distance/bbstyles/ol_css/ol_course-moodle.css' type='text/css' media='screen'>");
		
	var newLink = document.createElement("link");
	newLink.rel = "stylesheet";
	newLink.href = "https://www.tru.ca/distance/bbstyles/ol_css/ol_course-moodle.css";
	newLink.type = "text/css";
	newLink.media = "screen";
	
	if (window.location.href.indexOf("-sandbox") > -1) {

		newLink.href = "https://www.tru.ca/distance/bbstyles/ol_css/ol_course-moodle_sandbox.css";
		
	} else {
		
		newLink.href = "https://www.tru.ca/distance/bbstyles/ol_css/ol_course-moodle.css";
		
	}

	var links = document.querySelectorAll("head link[rel='stylesheet']");

	if (links.length > 0) {
	  let lastLink = links[links.length - 1];
	  lastLink.parentNode.insertBefore(newLink, lastLink.nextSibling);
	} else {
	  document.head.appendChild(newLink);
	}
	
	if (window.location.href.indexOf("quiz") !== -1 && window.location.href.indexOf("attempt") !== -1) {

	  let parentDiv = document.querySelector("div.activity-description");
	  let hasNoteDiv = parentDiv.querySelector("div[class^='note']") !== null;

	  if (hasNoteDiv) {
		let styleTag = document.createElement("style");
		styleTag.textContent = `
		  #page-mod-quiz-attempt.jsenabled .activity-description, 
		  #page-mod-quiz-startattempt.jsenabled .activity-description 
		  {display: none;}
		`;
		document.head.appendChild(styleTag);
	  }

	}

	setTimeout(() => {
		if (window.location.href.indexOf("modedit") !== -1) {
			let iframeDoc = document.getElementById('id_introeditor_ifr');
			if (iframeDoc) {
				let iframeDocWindow = document.getElementById('id_introeditor_ifr').contentWindow.document;
				let style = iframeDocWindow.createElement('style');
				style.innerHTML = '.mce-content-body .collapse:not(.show), .mce-content-body .qa-basic div[id^="answer_"] {display: block !important;}';
				iframeDocWindow.head.appendChild(style);
			}
		}
	}, 5000);
	
	require(['core_courseformat/courseindex'], function(courseIndex) {
		setTimeout(function () {
			document.querySelectorAll('li.courseindex-item a.courseindex-link').forEach(link => {
				const text = link.textContent.trim();
				if (/^bootstrapelements\d+$/.test(text) || /^label\d+$/.test(text)) {
					const li = link.closest('li.courseindex-item');
					if (li) {
						li.setAttribute('style', 'display: none !important');
					}
				}
			});
		}, 100);
	});

	if (window.jQuery) {
		
		// media resizer
		if ($('.mediaObject').length) {
			//$("head script[type='application/javascript']").last().after("<script type='application/javascript' src='https://barabus.tru.ca/_assets/js/moodle-resizer.js'></script>");
			let scriptEle = document.createElement("script");
			scriptEle.setAttribute("type", "text/javascript");
			scriptEle.setAttribute("src", 'https://barabus.tru.ca/_assets/js/moodle-resizer.js');
			//scriptEle.setAttribute("async", async);
			document.head.appendChild(scriptEle);
		}
		
		// new window auto link
		$("a.autolink").attr("target","_blank");
		
		// default always show description for assignments
		$('body#page-mod-assign-mod div#id_availabilitycontainer:has(#id_allowsubmissionsfromdate_enabled:not(:checked)) input#id_alwaysshowdescription').prop("checked", true);
		
		// temporary link changes
		$('.block_activity_modules a[href^="https://moodle.tru.ca/mod/pdfannotator/index.php"]').hide();
		$('.block_html a[href="http://www.tru.ca/__shared/assets/TRU-OL-Student-Handbook-27236.pdf"]').hide();
		$('.block_html a[href="https://mytru.tru.ca/cp/home/displaylogin"]').attr("href","https://mytru.tru.ca/");
		$('.block_html a[href="http://www.tru.ca/distance/services/resources/helpdesk.html"]').attr("href","https://tru.teamdynamix.com/TDClient/84/Portal/Home/");
		$('.block_html a[href$="www.tru.ca/library/distance.html"]').attr("href","https://www.tru.ca/library/services/distance.html");
		$('h5 a[href="https://barabus.tru.ca/student_orientation/raymond_cox_6021.html"]:contains("Associate Dean, Raymond Cox - Introduction")').hide();
		
		$('ul.section li:nth-child(n + 2):nth-child(-n + 6).activity div.activity-item a:contains("Getting Started"):contains("Moodle")').removeAttr("onclick","").attr("target","_blank").attr("href","https://moodle.tru.ca/course/view.php?id=46564");
		
		$('li:nth-child(n + 2):nth-child(-n + 6).courseindex-item a.courseindex-link:contains("Getting Started"):contains("Moodle")').attr("target","_blank").attr("href","https://moodle.tru.ca/course/view.php?id=46564");
		
		$('.urlworkaround a[href="https://www.tru.ca/distance/bbstyles/ol_html/moodle_help/"]').attr("href","https://moodle.tru.ca/course/view.php?id=46564");
		
		$('.activity a[href="https://www.proctoru.com/live-plus-resource-center#system"]').attr("href","https://support.proctoru.com/hc/en-us/articles/24692181239309-Equipment-Requirements");
		$('.activity a[href="https://www.proctoru.com/live-plus-resource-center#how"]').attr("href","https://support.proctoru.com/hc/en-us/articles/9951434736525-What-to-expect-on-exam-day-Guardian-Browser");
		$('.activity a[href="https://www.proctoru.com/live-plus-resource-center"]').attr("href","https://support.proctoru.com/hc/en-us/categories/115001818507-Test-Taker-Library");
		
		// hide button
		$('button:contains("This Course Menu")').text("Activities Block").hide();
		$('ul.section li:nth-child(n + 2):nth-child(-n + 6).activity div.activity-item:has(button:contains("Key Course Navigation Features"))').hide();
		
		// bind tooltips
		$('.tooltipLink').click(function(e) {
			
		   $(".tooltipContent").not($(this).data("target")).hide();
		   
		   var target = $(this).data("target");
		   var oLeft = $(this).offset().left-10;
		   
		   if ($("#theme_boost-drawers-courseindex").hasClass("show")) {
			   oLeft = 10;
		   }
		   
		   $($(this).data("target")).toggle();
		
		   $($(this).data("target")).css({'position':'absolute'});
		   $($(this).data("target")).css({left: oLeft + 'px',});

		   // hide after 20 seconds
		   timeout = setTimeout(function () {
				$(target).fadeOut();
		   }, 20000);
		   
		   return false;
		   
		}); 
		
		// Bind QA
		$(".exerciseContent .qa-check-btn").click(function() {
		  // get previous div sibling
		  var qDiv = $(this).prev("div"); 
		  var revealPara = "";
		  
		  if (qDiv.data('type') == 'short-answer') {

			  var exactFound = false, lesserFail = false, greaterFail = false;
			  var exacts = qDiv.data('answer-exact');
			  var lessers = qDiv.data('answer-lesser');
			  var greaters = qDiv.data('answer-greater');
			  
			  if ($.trim(qDiv.find(".qa-input-box").val())) {
				 var inputVal = qDiv.find(".qa-input-box").val();
				  
				 exactFound = ($.inArray(inputVal, exacts) >= 0) ? true : false;
				 
				  // do lesser comparisons
				  if (lessers.length > 0) {
					 for (i = 0; i < lessers.length; i++) {
						 if (parseFloat(lessers[i]) < parseFloat(inputVal)) {
							 lesserFail = true;
						}
					 }
				  } else {
					  lesserFail = true;
				  }
				 
				 // do greater comparisons
				 if (greaters.length > 0) {
					 for (i = 0; i < greaters.length; i++) {
						 if (parseFloat(greaters[i]) > parseFloat(inputVal)) {
							 greaterFail = true;
						}
					 }
				  } else {
					  greaterFail = true;
				  }
				  
				 qDiv.find(".qa-answer-text").stop();
				 if (exactFound || (!lesserFail && !greaterFail)) {
					  qDiv.find(".qa-answer-text").text("Correct");
					  qDiv.find(".qa-answer-text").addClass("qa-success");
					  qDiv.find(".qa-answer-text").removeClass("qa-error");
				  } else {
					  qDiv.find(".qa-answer-text").text("Incorrect");
					  qDiv.find(".qa-answer-text").addClass("qa-error");
					  qDiv.find(".qa-answer-text").removeClass("qa-success");
				  }
				  qDiv.find(".qa-input-box").removeClass("qa-error");
				  qDiv.find(".qa-answer-text").fadeIn();
			  } else {
				  qDiv.find(".qa-input-box").addClass("qa-error");
			  }
			  
		  } else if ($(this).prev().data('type') == 'long-answer') {
			  
			  if ($.trim(qDiv.find(".qa-input-box").val())) {
				  qDiv.find(".qa-answer-text").fadeIn();
				  qDiv.find(".qa-input-box").removeClass("qa-error");
			  } else {
				  qDiv.find(".qa-input-box").addClass("qa-error");
			  }
			  
		  } else if ($(this).prev().data('type') == 'multiple-choice') {
			  
			   var inputName = qDiv.find("input[type=radio]:checked").prop('name');

			   if (qDiv.find("input[name="+inputName+"]:checked").hasClass('qa-option-answer')) {
				   qDiv.find("input[name="+inputName+"]:checked").parent().addClass("qa-success");
				   qDiv.find(".qa-answer-text").fadeIn();
			   } else {
				   qDiv.find("input[name="+inputName+"]:checked").parent().addClass("qa-error");
			   } 
		  }
		  
		});
		
		// Set Gallery
		if ($('.olGallery').length ) {

			$('body').append('<div class="olGalleryImageBox"></div>');

			// image box
			var $overlay = $('<div class="imageBoxOverlay"></div>');
			var $figure = $('<div class="imageBoxFigure"></div>');
			var $caption = $('<div class="imageBoxCaption"></div>');
			var $image = $('<img>');
			var $prevButton = $('<div class="prevButton"><i class="fa fa-chevron-left"></i></div>');
			var $nextButton = $('<div class="nextButton"><i class="fa fa-chevron-right"></i></div>');
			var $exitButton = $('<div class="exitButton"><i class="fa fa-times"></i></div>');

			// add overlay
			$figure.append($image).append($caption);
			$overlay.append($figure).prepend($prevButton).append($nextButton).append($exitButton);
			$('.olGalleryImageBox').append($overlay);

			// hide overlay and caption on default
			$overlay.hide();
			$caption.hide();

			var $selectedImage = null;

			$(".olGallery .olGalleryItem").click(function(event) {
			  $caption.html("");
			  event.preventDefault();

			  $caption.html($(this).find(".caption").html());
			  var imageLocation = $(this).find("img").attr("src");
			  $image.attr("src", imageLocation);

			  $overlay.fadeIn(800);
			  $caption.fadeIn(800);

			  $selectedImage = $(this);
			});

			$overlay.click(function() {
			  $(this).fadeOut("slow");
			});

			// When next button is clicked
			$nextButton.click(function(event) {

			  $caption.hide();
			  $caption.html("");
			  $(".imageBoxOverlay img").hide();

			  var $nextImg = $($selectedImage).next().find("img");

			  if ($nextImg.length > 0) {

				$(".imageBoxOverlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
				$selectedImage = $($selectedImage).next();

			  } else {

				var $galleryImages = $selectedImage.parent().find("img");
				$(".imageBoxOverlay img").attr("src", $($galleryImages).first().attr("src")).fadeIn(800);
				$selectedImage = $($galleryImages).first().parent();
			  }

			  var $nextCaption = $($selectedImage.find(".caption"));

			  $caption.html($nextCaption.html());
			  $caption.fadeIn(800);

			  event.stopPropagation();
			});

			// When previous button is clicked
			$prevButton.click(function(event) {

				$caption.hide();
				$caption.html("");
				$(".imageBoxOverlay img").hide();

			  var $prevImg = $($selectedImage).prev().find("img");

				if ($prevImg.length > 0) {

					$(".imageBoxOverlay img").attr("src", $prevImg.attr("src")).fadeIn(800);
					$selectedImage = $($selectedImage).prev();

				} else {

					var $galleryImages = $selectedImage.parent().find("img");
					$(".imageBoxOverlay img").attr("src", $($galleryImages).last().attr("src")).fadeIn(800);
					$selectedImage = $($galleryImages).last().parent();
				}

				var $prevCaption = $($selectedImage.find(".caption"));

				$caption.html($prevCaption.html());
				$caption.fadeIn(800);

				event.stopPropagation();
			});

			// When the exit button is clicked
			$exitButton.click(function() {
			  $(".imageBoxOverlay").fadeOut("slow");
			});
		}
		
		function moveShowAnswerTextIntoAnchor() {
		  // Get all anchor tags with id starting with "aLink"
		  const anchors = document.querySelectorAll('a[id^="aLink"], a[id^="togLink"]');

		  anchors.forEach(anchor => {
			const parentP = anchor.closest('p');
			if (parentP && parentP.textContent.includes("Show Answer")) {
			  // Check if "Show Answer" is not already inside the anchor
			  if (!anchor.textContent.includes("Show Answer")) {
				// Move the text node containing "Show Answer" into the anchor
				const textNodes = Array.from(parentP.childNodes).filter(node =>
				  node.nodeType === Node.TEXT_NODE && node.textContent.includes("Show Answer")
				);

				textNodes.forEach(textNode => {
				  anchor.textContent += textNode.textContent.trim();
				  parentP.removeChild(textNode);
				});
			  }
			  anchor.setAttribute("href", '#');
			  anchor.classList.add('auto-btn');
			}
		  });
		}

		function setupAnswerToggleWithEffects() {
		  const anchors = document.querySelectorAll('a[id^="aLink_"], a[id^="togLink"], button[id^="aLink_"], button[id^="togLink_"]');

		  anchors.forEach(anchor => {
			anchor.addEventListener('click', function(event) {
			  event.preventDefault();

			  let anchorId = anchor.id.replace('aLink_', '');
			  let answerDiv = document.getElementById('answer_' + anchorId);
			
			  if (!answerDiv) {
				anchorId = anchor.id.replace('togLink_', '');	
				answerDiv = document.getElementById('toggle_' + anchorId);
			  }
				
			  if (answerDiv) {
				const isVisible = answerDiv.style.display === 'block';

				if (isVisible) {
				  // Fade out effect
				  let opacity = 1;
				  const duration = 300;
				  const interval = 30;
				  const decrement = interval / duration;

				  const fadeOut = setInterval(() => {
					opacity -= decrement;
					if (opacity <= 0) {
					  opacity = 0;
					  clearInterval(fadeOut);
					  answerDiv.style.display = 'none';
					}
					answerDiv.style.opacity = opacity;
				  }, interval);

				  let showTitle = anchor.getAttribute("data-show-title");
				  anchor.textContent = (showTitle != null) ? showTitle : "Show Answer";
				  
				} else {
				  // Apply styles
				  answerDiv.style.backgroundColor = '#f8f8f8';
				  answerDiv.style.padding = '5px';
				  answerDiv.style.marginBottom = '10px';
				  answerDiv.style.opacity = 0;
				  answerDiv.style.display = 'block';

				  // Fade-in effect
				  let opacity = 0;
				  const duration = 1000;
				  const interval = 50;
				  const increment = interval / duration;

				  const fadeIn = setInterval(() => {
					opacity += increment;
					if (opacity >= 1) {
					  opacity = 1;
					  clearInterval(fadeIn);
					}
					answerDiv.style.opacity = opacity;
				  }, interval);

				  let hideTitle = anchor.getAttribute("data-hide-title");
				  anchor.textContent = (hideTitle != null) ? hideTitle : "Hide Answer";
				}
			  }
			});
		  });
		}

		function validateAllAnchorHrefJavaScript() {
		  const anchors = document.querySelectorAll('a[id^="aLink"], a[id^="togLink"], button[id^="aLink_"], button[id^="togLink_"]');
		  let allValid = true;

		  anchors.forEach(anchor => {
			const href = anchor.getAttribute('href');
			if (!href || !href.trim().toLowerCase().startsWith('javascript:showhide')) {
			  allValid = false;
			}
		  });

		  return allValid;
		}

		const allValidResult = validateAllAnchorHrefJavaScript();
		
		if ( ! allValidResult) {
			moveShowAnswerTextIntoAnchor();		
			setupAnswerToggleWithEffects();
		}	
	}

}, false);


// Set Toggles
var showhide = function(linkRef, toggleRef, showText, hideText) {
	
	if (window.jQuery) {
		// escape periods for JQuery
		linkRef = linkRef.replace(".", "\\.");
		toggleRef = toggleRef.replace(".", "\\.");

		if ($("#"+toggleRef).is(":visible")) {
			$("#"+toggleRef).hide();
			$("#"+linkRef).text(showText);
		} else {
			$("#"+toggleRef).fadeIn(1000);
			$("#"+toggleRef).css("background-color","#f8f8f8");
			$("#"+toggleRef).css("padding","5px");
			$("#"+toggleRef).css("margin-bottom","10px");
			$("#"+linkRef).text(hideText);
		}
	}
	
};
	