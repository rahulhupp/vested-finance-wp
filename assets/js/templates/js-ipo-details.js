// Function to scroll active tab to center
function scrollActiveTabToCenter(activeTab) {
	if (!activeTab) return;
	
	const tabsContainer = document.querySelector('.ipo_tabs');
	if (!tabsContainer) return;
	
	// Get container and tab dimensions
	const containerRect = tabsContainer.getBoundingClientRect();
	const tabRect = activeTab.getBoundingClientRect();
	
	// Calculate the center position
	const containerCenter = containerRect.left + containerRect.width / 2;
	const tabCenter = tabRect.left + tabRect.width / 2;
	
	// Calculate scroll offset to center the tab
	const scrollOffset = tabCenter - containerCenter;
	
	// Only scroll if the tab is not already centered (within 10px tolerance)
	if (Math.abs(scrollOffset) > 10) {
		// Scroll the tabs container
		tabsContainer.scrollBy({
			left: scrollOffset,
			behavior: 'smooth'
		});
	}
}

// Smooth scroll for tab navigation
const tabs = document.querySelectorAll('.ipo_tab');
tabs.forEach(tab => {
	tab.addEventListener('click', function (e) {
		console.log('click');
		
		e.preventDefault();
		
		// Remove active class from all tabs
		tabs.forEach(t => t.classList.remove('active'));
		
		// Add active class to clicked tab
		this.classList.add('active');
		
		// Scroll active tab to center (mobile only)
		if (window.innerWidth <= 991) {
			scrollActiveTabToCenter(this);
		}
		
		const target = document.querySelector(this.getAttribute('data-target'));
		if (target) {
			window.scrollTo({
				top: target.getBoundingClientRect().top + window.pageYOffset - 120,
				behavior: 'smooth'
			});
		}
	});
});

// Dynamic tab and section management
function getVisibleSectionsAndTabs() {
	const visibleTabs = [];
	const visibleSections = [];
	
	// Get all tabs and their corresponding sections
	tabs.forEach(tab => {
		const targetId = tab.getAttribute('data-target');
		const targetSection = document.querySelector(targetId);
		
		// Check if section exists and is visible
		if (targetSection && isElementVisible(targetSection)) {
			visibleTabs.push(tab);
			visibleSections.push(targetSection);
		}
	});
	
	return { visibleTabs, visibleSections };
}

// Helper function to check if an element is visible
function isElementVisible(element) {
	// Check if element exists and has dimensions
	if (!element || element.offsetWidth === 0 || element.offsetHeight === 0) {
		return false;
	}
	
	// Check if element is not hidden by CSS
	const style = window.getComputedStyle(element);
	if (style.display === 'none' || style.visibility === 'hidden') {
		return false;
	}
	
	// Check if element is in the document flow
	if (element.offsetParent === null && element !== document.body) {
		return false;
	}
	
	return true;
}

// Initialize tabs - ensure first visible tab is active
function initializeTabs() {
	const { visibleTabs } = getVisibleSectionsAndTabs();
	
	// Remove active class from all tabs first
	tabs.forEach(tab => tab.classList.remove('active'));
	
	// Set the first visible tab as active
	if (visibleTabs.length > 0) {
		visibleTabs[0].classList.add('active');
		// Scroll active tab to center on mobile
		if (window.innerWidth <= 991) {
			scrollActiveTabToCenter(visibleTabs[0]);
		}
	}
}

// Highlight active tab on scroll and handle sticky tabs
const ipoTabs = document.querySelector('.ipo_tabs');

window.addEventListener('scroll', function () {
	let scrollPos = window.scrollY || window.pageYOffset;
	let offset = 140;
	let activeIdx = 0;
	
	// Get current visible sections and tabs
	const { visibleTabs, visibleSections } = getVisibleSectionsAndTabs();
	
	// Handle sticky tabs
	if (ipoTabs) {
		const tabsRect = ipoTabs.getBoundingClientRect();
		const tabsOffsetTop = ipoTabs.offsetTop;
		
		if (scrollPos >= tabsOffsetTop) {
			ipoTabs.classList.add('sticky');
		} else {
			ipoTabs.classList.remove('sticky');
		}
	}
	
	// Find the active section based on scroll position
	for (let i = 0; i < visibleSections.length; i++) {
		if (visibleSections[i] && scrollPos + offset >= visibleSections[i].offsetTop) {
			activeIdx = i;
		}
	}
	
	// Update active tab
	visibleTabs.forEach((tab, idx) => {
		if (idx === activeIdx) {
			tab.classList.add('active');
			// Scroll active tab to center on mobile when it changes due to scroll
			if (window.innerWidth <= 991) {
				scrollActiveTabToCenter(tab);
			}
		} else {
			tab.classList.remove('active');
		}
	});
});

const buttons = document.querySelectorAll('.ipo_faq_question');

buttons.forEach(button => {
  button.addEventListener('click', () => {
    const item = button.parentElement;
    const answer = item.querySelector('.ipo_faq_answer');

    if (item.classList.contains('active')) {
      answer.style.maxHeight = null;
      item.classList.remove('active');
    } else {
      document.querySelectorAll('.ipo_faq_answer').forEach(a => {
        a.style.maxHeight = null;
        a.parentElement.classList.remove('active');
      });
      answer.style.maxHeight = answer.scrollHeight + 'px';
      item.classList.add('active');
    }
  });
});

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
	// Initialize tabs
	initializeTabs();
	
	// Handle window resize - sections might become visible/hidden
	window.addEventListener('resize', function() {
		// Debounce resize events
		clearTimeout(window.resizeTimeout);
		window.resizeTimeout = setTimeout(function() {
			initializeTabs();
		}, 250);
	});
	
	// News "View More" functionality
  const viewMoreBtn = document.querySelector('.ipo_news_view_more_btn');
  
  if (viewMoreBtn) {
    viewMoreBtn.addEventListener('click', function() {
      const newsList = document.querySelector('.ipo_news_list');
      const hiddenItems = newsList.querySelectorAll('.ipo_news_item_hidden');
      const itemsPerLoad = 3;
      const currentShown = parseInt(this.getAttribute('data-shown'));
      const totalItems = parseInt(this.getAttribute('data-total'));
      
      // Show next 3 items
      const itemsToShow = Math.min(itemsPerLoad, hiddenItems.length);
      for (let i = 0; i < itemsToShow; i++) {
        if (hiddenItems[i]) {
          hiddenItems[i].classList.remove('ipo_news_item_hidden');
        }
      }
      
      // Update button state
      const newShown = currentShown + itemsToShow;
      this.setAttribute('data-shown', newShown);
      
      // Disable button if all items are shown
      if (newShown >= totalItems) {
        this.disabled = true;
        this.textContent = 'All News Shown';
      }
    });
  }
  
  // Research Reports "View More" functionality
  const researchViewMoreBtn = document.querySelector('.ipo_research_view_more_btn');
  
  if (researchViewMoreBtn) {
    researchViewMoreBtn.addEventListener('click', function() {
      const researchList = document.querySelector('.ipo_research_list');
      const hiddenItems = researchList.querySelectorAll('.ipo_research_item_hidden');
      const itemsPerLoad = 5;
      const currentShown = parseInt(this.getAttribute('data-shown'));
      const totalItems = parseInt(this.getAttribute('data-total'));
      
      // Show next 5 items
      const itemsToShow = Math.min(itemsPerLoad, hiddenItems.length);
      for (let i = 0; i < itemsToShow; i++) {
        if (hiddenItems[i]) {
          hiddenItems[i].classList.remove('ipo_research_item_hidden');
        }
      }
      
      // Update button state
      const newShown = currentShown + itemsToShow;
      this.setAttribute('data-shown', newShown);
      
      // Disable button if all items are shown
      if (newShown >= totalItems) {
        this.disabled = true;
        this.textContent = 'All Research Reports Shown';
      }
    });
  }
  
  // FAQ "View More" functionality
  const faqViewMoreBtn = document.querySelector('.ipo_faq_view_more_btn');
  
  if (faqViewMoreBtn) {
    faqViewMoreBtn.addEventListener('click', function() {
      const faqContainer = document.querySelector('.ipo_faq_container');
      const hiddenItems = faqContainer.querySelectorAll('.ipo_faq_item_hidden');
      const itemsPerLoad = 4;
      const currentShown = parseInt(this.getAttribute('data-shown'));
      const totalItems = parseInt(this.getAttribute('data-total'));
      
      // Show next 4 items
      const itemsToShow = Math.min(itemsPerLoad, hiddenItems.length);
      for (let i = 0; i < itemsToShow; i++) {
        if (hiddenItems[i]) {
          hiddenItems[i].classList.remove('ipo_faq_item_hidden');
        }
      }
      
      // Update button state
      const newShown = currentShown + itemsToShow;
      this.setAttribute('data-shown', newShown);
      
      // Disable button if all items are shown
      if (newShown >= totalItems) {
        this.disabled = true;
        this.textContent = 'All FAQs Shown';
      }
    });
  }
});


function copyLink() {
	var inputElement = document.createElement("input");
	// inputElement.value = window.location.href;
	inputElement.value = "http://app.vestedfinance.com/en/global/pre-ipo?toExternalLandingPage=true";
	document.body.appendChild(inputElement);
	inputElement.select();
	document.execCommand("copy"); // This command copies the selected text
	document.body.removeChild(inputElement);

	for (var i = 0; i < 5; i++) {
		displayMessage();
	}
}

function displayMessage() {
	var copyMessage = document.getElementById("copy_link_message");
	copyMessage.classList.add('active');
	setTimeout(function () {
		copyMessage.classList.remove('active');
	}, 2000);
}

// Funding Rounds Popup Functions
function openFundingRoundsPopup() {
	const popup = document.getElementById('funding_rounds_popup');
	popup.classList.add('active');
	document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeFundingRoundsPopup() {
	const popup = document.getElementById('funding_rounds_popup');
	popup.classList.remove('active');
	document.body.style.overflow = ''; // Restore scrolling
}

// Close popup with Escape key
document.addEventListener('keydown', function(event) {
	if (event.key === 'Escape') {
		closeFundingRoundsPopup();
	}
});