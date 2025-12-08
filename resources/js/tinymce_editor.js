import tinymce from 'tinymce';

import 'tinymce/themes/silver';
import 'tinymce/icons/default';
import 'tinymce/models/dom';

import 'tinymce/plugins/table';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/code';

// Skins (CSS)
import 'tinymce/skins/ui/oxide/skin.css';
import 'tinymce/skins/content/default/content.css';

tinymce.init({
    license_key: 'gpl',
    selector: '.tinymce',
    menubar: 'file edit view insert format tools help',

    toolbar: `
        undo redo |
        fontFamily |
        fontSize |
        fontSizeInput |
        bold italic underline |
        forecolor backcolor |
        alignleft aligncenter alignright alignjustify |
        numlist bullist |
        outdent indent |
        link |
        removeformat
    `,

    skin: false,
    content_css: false,

    height: 800,
    resize: 'both',
    branding: false,

    plugins: ` lists link table`,

    statusbar: false,

    toolbar_mode: 'wrap',
    promotion: false,
});