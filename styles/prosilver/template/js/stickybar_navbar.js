jQuery(document).ready(function ($) {
    'use strict';

    var $staticHeader = $('#static-header');
    var $originalNavbar = $('#page-header > .navbar');

    if (!$staticHeader.length || !$originalNavbar.length) {
        return;
    }

    var staticRoot = $staticHeader.get(0);
    var originalRoot = $originalNavbar.get(0);
    var stickyShown = false;

    var NAVBAR_ID_TARGETS = [
        'notification_list_button',
        'notification_list',
        'mark_all_notifications',
        'quick-links',
        'nav-main',
        'nav-breadcrumbs',
        'username_logged_in'
    ];
    var OPTIONAL_IDS = ['mark_all_notifications'];
    var DATA_ATTRIBUTE = 'data-stickybar-id';

    var markDropdownRelatives = function (element, id) {
        if (!element || !id) {
            return;
        }

        if (element.getAttribute(DATA_ATTRIBUTE) !== id) {
            element.setAttribute(DATA_ATTRIBUTE, id);
        }

        var $element = $(element);
        var container = $element.closest('.dropdown-container').get(0);

        if (!container && element.querySelector) {
            container = element.querySelector('.dropdown-container');
        }

        if (container && container.getAttribute(DATA_ATTRIBUTE) !== id) {
            container.setAttribute(DATA_ATTRIBUTE, id);
        }

        var toggle = null;

        if ($element.hasClass('dropdown-toggle') || $element.hasClass('dropdown-trigger')) {
            toggle = element;
        } else if (container) {
            toggle = container.querySelector('.dropdown-toggle, .dropdown-trigger');
        } else if (element.querySelector) {
            toggle = element.querySelector('.dropdown-toggle, .dropdown-trigger');
        }

        if (toggle && toggle.getAttribute(DATA_ATTRIBUTE) !== id) {
            toggle.setAttribute(DATA_ATTRIBUTE, id);
        }

        var dropdown = null;

        if (container) {
            dropdown = container.querySelector('.dropdown');
        } else if (element.classList && element.classList.contains('dropdown')) {
            dropdown = element;
        }

        if (dropdown && dropdown.getAttribute(DATA_ATTRIBUTE) !== id) {
            dropdown.setAttribute(DATA_ATTRIBUTE, id);
        }
    };
    var stampDataAttributes = function (root) {
        if (!root) {
            return;
        }

        NAVBAR_ID_TARGETS.forEach(function (id) {
            var element = root.querySelector('[id="' + id + '"]');

            if (element && element.getAttribute(DATA_ATTRIBUTE) !== id) {
                markDropdownRelatives(element, id);
            }
        });
    };

    var isDropdownOpen = function (toggle) {
        if (!toggle) {
            return false;
        }

        var $container = $(toggle).closest('.dropdown-container');

        return $container.hasClass('dropdown-visible') || $container.hasClass('visible');
    };

    var collectOpenDropdownInfo = function (root) {
        if (!root) {
            return null;
        }

        var openContainer = root.querySelector('.dropdown-container.dropdown-visible');

        if (!openContainer) {
            openContainer = root.querySelector('.dropdown-container.visible');
        }

        if (!openContainer) {
            return null;
        }

        var toggle = openContainer.querySelector('.dropdown-toggle, .dropdown-trigger');

        if (!toggle) {
            return null;
        }

        var referenceId = toggle.getAttribute(DATA_ATTRIBUTE) || toggle.getAttribute('id');

        if (!referenceId) {
            var labelledAncestor = $(toggle).closest('[' + DATA_ATTRIBUTE + ']').get(0);

            if (labelledAncestor) {
                referenceId = labelledAncestor.getAttribute(DATA_ATTRIBUTE) || labelledAncestor.getAttribute('id');
            }
        }

        if (!referenceId) {
            var labelledDropdown = openContainer.querySelector('.dropdown[' + DATA_ATTRIBUTE + ']');

            if (!labelledDropdown) {
                labelledDropdown = openContainer.querySelector('.dropdown[id]');
            }

            if (labelledDropdown) {
                referenceId = labelledDropdown.getAttribute(DATA_ATTRIBUTE) || labelledDropdown.getAttribute('id');
            }
        }

        return {
            toggle: toggle,
            referenceId: referenceId,
            ariaExpanded: toggle.getAttribute('aria-expanded'),
            wasFocused: document.activeElement === toggle
        };
    };

    var closeCollectedDropdown = function (info) {
        if (!info || !info.toggle || typeof window.phpbb === 'undefined' || typeof window.phpbb.toggleDropdown !== 'function') {
            return;
        }

        if (isDropdownOpen(info.toggle)) {
            window.phpbb.toggleDropdown.call(info.toggle);
        }
    };

    var findMatchingToggle = function (root, referenceId) {
        if (!root || !referenceId) {
            return null;
        }

        var attrSelector = '[' + DATA_ATTRIBUTE + '="' + referenceId + '"]';
        var match = root.querySelector(attrSelector);

        if (!match) {
            match = root.querySelector('[id="' + referenceId + '"]');
        }

        var candidate = null;

        if (match) {
            if ($(match).is('.dropdown-toggle, .dropdown-trigger')) {
                candidate = match;
            } else {
                candidate = match.querySelector('.dropdown-toggle, .dropdown-trigger');

                if (!candidate) {
                    var closestContainer = $(match).closest('.dropdown-container').get(0);

                    if (!closestContainer && match.querySelector) {
                        closestContainer = match.querySelector('.dropdown-container');
                    }

                    if (closestContainer) {
                        candidate = closestContainer.querySelector('.dropdown-toggle, .dropdown-trigger');
                    }
                }
            }
        }

        if (!candidate) {
            var dropdownMatch = root.querySelector('.dropdown' + attrSelector);

            if (!dropdownMatch) {
                dropdownMatch = root.querySelector('.dropdown[id="' + referenceId + '"]');
            }

            if (dropdownMatch) {
                var dropdownContainer = $(dropdownMatch).closest('.dropdown-container').get(0) || dropdownMatch.parentNode;

                if (dropdownContainer) {
                    candidate = dropdownContainer.querySelector('.dropdown-toggle, .dropdown-trigger');
                }
            }
        }

        return candidate || null;
    };

    var openCollectedDropdown = function (info, activeRoot) {
        if (!info || !activeRoot || !info.referenceId || typeof window.phpbb === 'undefined' || typeof window.phpbb.toggleDropdown !== 'function') {
            return;
        }

        var targetToggle = findMatchingToggle(activeRoot, info.referenceId);

        if (!targetToggle) {
            return;
        }

        if (!isDropdownOpen(targetToggle)) {
            window.phpbb.toggleDropdown.call(targetToggle);
        }

        if (info.ariaExpanded !== null && info.ariaExpanded !== undefined) {
            targetToggle.setAttribute('aria-expanded', info.ariaExpanded);
        }

        if (info.wasFocused) {
            targetToggle.focus();
        }
    };

    // Raccoglie e chiude il dropdown aperto nell'header che sta per diventare inattivo.
    // Restituisce i metadati necessari per riaprire il menu dopo il passaggio degli ID.
    var prepareDropdownHandoff = function (inactiveRoot) {
        var info = collectOpenDropdownInfo(inactiveRoot);

        closeCollectedDropdown(info);

        return info;
    };

    // Riapre nell'header attivo il dropdown migrato preservando focus e aria-expanded.
    // Ignora l'operazione se manca un toggle gemello o phpBB non ha inizializzato i dropdown.
    var finalizeDropdownHandoff = function (info, activeRoot) {
        if (!info) {
            return;
        }

        openCollectedDropdown(info, activeRoot);
    };

    var syncBadgeText = function (sourceRoot, targetRoot) {
        if (!sourceRoot || !targetRoot) {
            return;
        }

        NAVBAR_ID_TARGETS.forEach(function (id) {
            var selector = '[' + DATA_ATTRIBUTE + '="' + id + '"]';
            var sourceNode = sourceRoot.querySelector(selector);
            var targetNode = targetRoot.querySelector(selector);

            if (!sourceNode || !targetNode) {
                return;
            }

            var sourceBadges = sourceNode.querySelectorAll('.badge');
            var targetBadges = targetNode.querySelectorAll('.badge');

            for (var i = 0; i < sourceBadges.length && i < targetBadges.length; i++) {
                if (targetBadges[i].textContent !== sourceBadges[i].textContent) {
                    targetBadges[i].textContent = sourceBadges[i].textContent;
                }

                if (targetBadges[i].className !== sourceBadges[i].className) {
                    targetBadges[i].className = sourceBadges[i].className;
                }
            }
        });
    };

    var mirrorOptionalState = function (sourceRoot, targetRoot) {
        if (!sourceRoot || !targetRoot || !OPTIONAL_IDS.length) {
            return;
        }

        OPTIONAL_IDS.forEach(function (id) {
            var selector = '[' + DATA_ATTRIBUTE + '="' + id + '"]';
            var sourceNode = sourceRoot.querySelector(selector);
            var targetNode = targetRoot.querySelector(selector);
            var shouldShow = false;

            if (sourceNode) {
                shouldShow = !$(sourceNode).hasClass('hidden');
            }

            if (targetNode) {
                $(targetNode).toggleClass('hidden', !shouldShow);
            }

            if (sourceNode) {
                $(sourceNode).toggleClass('hidden', !shouldShow);
            }
        });
    };

    var toggleAriaStates = function (activeRoot, inactiveRoot) {
        if (activeRoot) {
            activeRoot.setAttribute('aria-hidden', 'false');
        }

        if (inactiveRoot) {
            inactiveRoot.setAttribute('aria-hidden', 'true');
        }
    };

    // Keep dropdown IDs unique so phpBB always targets the visible navbar.
    var swapActiveNavbarIds = function (activeRoot, inactiveRoot) {
        if (!activeRoot || !inactiveRoot) {
            return;
        }

        stampDataAttributes(activeRoot);
        stampDataAttributes(inactiveRoot);
        mirrorOptionalState(inactiveRoot, activeRoot);

        NAVBAR_ID_TARGETS.forEach(function (id) {
            var inactiveNode = inactiveRoot.querySelector('[' + DATA_ATTRIBUTE + '="' + id + '"]');

            if (inactiveNode && inactiveNode.id === id) {
                inactiveNode.removeAttribute('id');
            }
        });

        NAVBAR_ID_TARGETS.forEach(function (id) {
            var activeNode = activeRoot.querySelector('[' + DATA_ATTRIBUTE + '="' + id + '"]');

            if (activeNode && activeNode.id !== id) {
                activeNode.setAttribute('id', id);
            }
        });

        toggleAriaStates(activeRoot, inactiveRoot);
    };

    stampDataAttributes(originalRoot);
    stampDataAttributes(staticRoot);
    swapActiveNavbarIds(originalRoot, staticRoot);

    var fixedNav = function () {
        var navbarOffset = $originalNavbar.offset();

        if (!navbarOffset) {
            return;
        }

        var fixedTop = navbarOffset.top;
        var fixedWidth = $('#page-body').outerWidth();
        var scrollTop = $(window).scrollTop();
        var shouldShowSticky = scrollTop > fixedTop;

        if (!fixedWidth) {
            fixedWidth = $originalNavbar.outerWidth();
        }

        if (fixedWidth) {
            $staticHeader.width(fixedWidth);
        }

        if (shouldShowSticky) {
            $staticHeader.addClass('shown').removeClass('not-shown');

            if (!stickyShown) {
                var handoffInfo = prepareDropdownHandoff(originalRoot);

                syncBadgeText(originalRoot, staticRoot);
                swapActiveNavbarIds(staticRoot, originalRoot);
                finalizeDropdownHandoff(handoffInfo, staticRoot);
                stickyShown = true;
            }
        } else {
            $staticHeader.addClass('not-shown').removeClass('shown');

            if (stickyShown) {
                var reverseHandoff = prepareDropdownHandoff(staticRoot);

                syncBadgeText(staticRoot, originalRoot);
                swapActiveNavbarIds(originalRoot, staticRoot);
                finalizeDropdownHandoff(reverseHandoff, originalRoot);
                stickyShown = false;
            }
        }
    };

    fixedNav();
    $(window).scroll(fixedNav);
    $(window).resize(fixedNav);
});
