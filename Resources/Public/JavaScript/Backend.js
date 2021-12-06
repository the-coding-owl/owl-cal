define(['TYPO3/CMS/Backend/Modal','TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/Severity'], function(Modal, Notification, Severity) {
    "use strict";
    const importButton = document.getElementById('owl-cal-calendar-import');
    if (importButton) {
        importButton.addEventListener('click', (e) => {
            e.preventDefault();
            Modal.loadUrl(
                TYPO3.lang['calendar.import.title'],
                Severity.info,
                [
                    {
                        text: TYPO3.lang['calendar.import.btn'],
                        icon: 'upload',
                        trigger: function(e) {
                            e.preventDefault();
                            Modal.currentModal.find('owl-cal-import-form').submit();
                            Modal.currentModal.modal('hide');
                        },
                        name: 'import'
                    },{
                        text: TYPO3.lang['cancel'],
                        icon: 'x'
                    }
                ],
                e.target.dataset['ajaxUrl']
            );
        });
    }
});
