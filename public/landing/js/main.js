document.addEventListener('DOMContentLoaded', function() {
    const smoothScrollEnabled = false;
    let isScrollingFromClick = false;
    
    function initializeActiveNav() {
        const activeLink = document.querySelector('.navbar-nav-custom a.active');
        if (activeLink) {
            const targetId = activeLink.getAttribute('href');
            updateActiveNav(targetId);
        }
    }
    
    function smoothScrollTo(targetPosition, duration) {
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;
        
        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            } else {
                isScrollingFromClick = false;
            }
        }
        
        function ease(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }
        
        requestAnimationFrame(animation);
    }

    function updateActiveNav(targetId) {
        const navContainer = document.querySelector('.navbar-nav-custom');
        const links = document.querySelectorAll('.navbar-nav-custom a');
        
        links.forEach((link, index) => {
            link.classList.remove('active');
            if (link.getAttribute('href') === targetId) {
                link.classList.add('active');
                
                if (window.innerWidth > 768) {
                    if (index === 0) {
                        navContainer.removeAttribute('data-active');
                    } else {
                        navContainer.setAttribute('data-active', index);
                    }
                } else {

                    const linkRect = link.getBoundingClientRect();
                    const navRect = navContainer.getBoundingClientRect();
                    const leftPosition = link.offsetLeft;
                    const linkWidth = link.offsetWidth;
                    
                    const afterElement = navContainer;
                    afterElement.style.setProperty('--mobile-left', leftPosition + 'px');
                    afterElement.style.setProperty('--mobile-width', linkWidth + 'px');

                    link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
            }
        });
    }
    
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');

            isScrollingFromClick = true;
            updateActiveNav(targetId);

            if (targetId === '#top') {
                if (smoothScrollEnabled) {
                    smoothScrollTo(0, 400);
                } else {
                    window.scrollTo(0, 0);
                    isScrollingFromClick = false;
                }
            } else {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const targetPosition = targetElement.offsetTop - 50;
                    if (smoothScrollEnabled) {
                        smoothScrollTo(targetPosition, 400);
                    } else {
                        window.scrollTo(0, targetPosition);
                        isScrollingFromClick = false;
                    }
                }
            }
        });
    });

    window.addEventListener('scroll', function() {
        if (isScrollingFromClick) return;
        
        const scrollPosition = window.pageYOffset + 150; 
        
        const faqSection = document.querySelector('#faq');
        const introSection = document.querySelector('#intro');
        
        let currentSection = '#top';
        
        if (faqSection && scrollPosition >= faqSection.offsetTop - 100) {
            currentSection = '#faq';
        } else if (introSection && scrollPosition >= introSection.offsetTop - 100) {
            currentSection = '#intro';
        } else {
            currentSection = '#top';
        }
        
        const currentActive = document.querySelector('.navbar-nav-custom a.active');
        const shouldBeActive = document.querySelector(`a[href="${currentSection}"]`);
        
        if (currentActive && shouldBeActive && currentActive !== shouldBeActive) {
            updateActiveNav(currentSection);
        }
    });
    
    window.addEventListener('resize', function() {
        const activeLink = document.querySelector('.navbar-nav-custom a.active');
        if (activeLink) {
            const targetId = activeLink.getAttribute('href');
            updateActiveNav(targetId);
        }
    });
    
    initializeActiveNav();
});

(function() {
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    const linkMapping = {
        'login': {
            mobile: 'https://m.pweng.net/login-v2.php',
            pc: 'https://www.pweng.net/login-v2.php'
        },
        'support': {
            mobile: 'https://m.pweng.net/me/support.php',
            pc: 'https://www.pweng.net/me/support.php'
        },
        'faq': {
            mobile: 'https://m.pweng.net/faq-v2.php',
            pc: 'https://www.pweng.net/faq.php'
        },
        'terms': {
            mobile: 'https://m.pweng.net/term-of-use.php',
            pc: 'https://www.pweng.net/agreement.php#-agreement'
        },
        'privacy': {
            mobile: 'https://m.pweng.net/privacy-policy.php',
            pc: 'https://www.pweng.net/agreement.php#-policy'
        },
        'pc-version': {
            mobile: 'https://www.pweng.net/index.php?site_type=PC',
            pc: 'https://m.pweng.net/?site_type=M'
        },
        'level-test': {
            mobile: 'https://m.pweng.net/level-test.php',
            pc: 'https://www.pweng.net/level-test.php'
        }
    };

    let previousDeviceState = null;

    function updateDynamicLinks() {
        const isMobile = isMobileDevice();
        
        if (previousDeviceState === isMobile) {
            return;
        }
        
        previousDeviceState = isMobile;
        
        document.querySelectorAll('.dynamic-link').forEach(function(link) {
            const linkType = link.getAttribute('data-link-type');
            if (linkMapping[linkType]) {
                link.href = isMobile ? linkMapping[linkType].mobile : linkMapping[linkType].pc;
            }
        });

        document.querySelectorAll('.level-test-link').forEach(function(link) {
            link.href = isMobile ? linkMapping['level-test'].mobile : linkMapping['level-test'].pc;
        });
    }

    let updateTimeout;
    function debouncedUpdate() {
        clearTimeout(updateTimeout);
        updateTimeout = setTimeout(updateDynamicLinks, 100);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateDynamicLinks);
    } else {
        updateDynamicLinks();
    }

    window.addEventListener('resize', debouncedUpdate);
    
    window.addEventListener('orientationchange', function() {
        setTimeout(updateDynamicLinks, 100);
    });

    setInterval(function() {
        const currentIsMobile = isMobileDevice();
        if (previousDeviceState !== null && previousDeviceState !== currentIsMobile) {
            updateDynamicLinks();
        }
    }, 500);
})();
