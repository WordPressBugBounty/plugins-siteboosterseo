/* V: 1.3.0 */
document.addEventListener('DOMContentLoaded', () => {
  dcjSbseoTextPrinter(
    '#dcjmyplug-home-title',
    '#dcjmyplug-preview-title'
  );

  dcjSbseoTextPrinter(
    '#dcjmyplug-home-description',
    '#dcjmyplug-preview-description',
    {
      afterUpdate: dcjSbseoAutoResizeTextarea
    }
  );

  dcjSbseoDescriptionPreview('#dcjmyplug-preview-description');
/*go back url bar */

(function () {
	'use strict';

	const storageKey = 'siteboosterseo_feedback_review_clicked';

	function hideFeedbackNotice() {
		document.querySelectorAll('.sbseo-feedback-notice').forEach(function (notice) {
			notice.remove();
		});
	}

	document.addEventListener('click', function (event) {
		const reviewButton = event.target.closest('[data-sbseo-feedback-action="review"]');

		if (!reviewButton) {
			return;
		}

		try {
			sessionStorage.setItem(storageKey, '1');
		} catch (error) {
			// sessionStorage may be unavailable in some browser/privacy modes.
		}

		hideFeedbackNotice();
	});

	window.addEventListener('pageshow', function () {
		let reviewClicked = false;

		try {
			reviewClicked = sessionStorage.getItem(storageKey) === '1';
		} catch (error) {
			reviewClicked = false;
		}

		if (reviewClicked) {
			hideFeedbackNotice();
		}
	});
})();


/*go back url bar */
});

/**
 * Returns an element from a selector or HTMLElement.
 *
 * @param {string|HTMLElement} selectorOrElement
 * @return {HTMLElement|null}
 */
function dcjSbseoGetElement(selectorOrElement) {
  if (selectorOrElement instanceof HTMLElement) {
    return selectorOrElement;
  }

  if (typeof selectorOrElement === 'string') {
    return document.querySelector(selectorOrElement);
  }

  return null;
}

/**
 * Reflects in real time the value entered in a field
 * within another input, textarea or preview element.
 *
 * @param {string|HTMLElement} sourceSelector Origin field.
 * @param {string|HTMLElement} targetSelector Target field.
 * @param {Object} options Extra options.
 * @param {Function} options.afterUpdate Callback after updating target.
 */
function dcjSbseoTextPrinter(sourceSelector, targetSelector, options = {}) {
  const source = dcjSbseoGetElement(sourceSelector);
  const target = dcjSbseoGetElement(targetSelector);

  if (!source || !target) {
    return;
  }

  const dcjSbseoUpdatePreviewText = () => {
    const value = source.value ?? source.textContent ?? '';

    if (
      target instanceof HTMLInputElement ||
      target instanceof HTMLTextAreaElement
    ) {
      target.value = value;
    } else {
      target.textContent = value;
    }

    if (typeof options.afterUpdate === 'function') {
      options.afterUpdate(target);
    }
  };

  source.addEventListener('input', dcjSbseoUpdatePreviewText);

  dcjSbseoUpdatePreviewText();
}

/**
 * Auto-resizes a textarea according to its content.
 *
 * @param {HTMLElement} textarea
 */
function dcjSbseoAutoResizeTextarea(textarea) {
  if (!(textarea instanceof HTMLTextAreaElement)) {
    return;
  }

  textarea.style.height = 'auto';
  textarea.style.height = textarea.scrollHeight + 'px';
}

/**
 * Initializes textarea auto-resize.
 *
 * @param {string|HTMLElement} mi_textarea Textarea selector or element.
 */
const dcjSbseoDescriptionPreview = function (mi_textarea) {
  const textarea = dcjSbseoGetElement(mi_textarea);

  if (!(textarea instanceof HTMLTextAreaElement)) {
    return;
  }

  textarea.style.overflowY = 'hidden';
  textarea.style.resize = 'none';

  dcjSbseoAutoResizeTextarea(textarea);

  textarea.addEventListener('input', () => {
    dcjSbseoAutoResizeTextarea(textarea);
  });
};