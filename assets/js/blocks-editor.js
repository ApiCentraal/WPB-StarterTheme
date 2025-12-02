/**
 * Bootstrap Blocks - Editor JavaScript
 *
 * Registreert Bootstrap blocks voor de Gutenberg editor.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

(function (blocks, element, blockEditor, components, i18n) {
    const { registerBlockType } = blocks;
    const { createElement: el, Fragment } = element;
    const { InnerBlocks, InspectorControls, useBlockProps } = blockEditor;
    const { PanelBody, SelectControl, ToggleControl, TextControl, RangeControl } = components;
    const { __ } = i18n;

    // =============================================================================
    // CONTAINER BLOCK
    // =============================================================================
    registerBlockType('wpbs/container', {
        title: __('Bootstrap Container', 'wp-bootstrap-starter'),
        icon: 'layout',
        category: 'design',
        description: __('Bootstrap container voor content layout.', 'wp-bootstrap-starter'),
        supports: {
            align: ['wide', 'full'],
            html: false,
        },
        attributes: {
            fluid: { type: 'boolean', default: false },
            breakpoint: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps({
                className: attributes.fluid ? 'is-fluid' : '',
            });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Container Instellingen', 'wp-bootstrap-starter') },
                        el(ToggleControl, {
                            label: __('Fluid Container', 'wp-bootstrap-starter'),
                            checked: attributes.fluid,
                            onChange: (val) => setAttributes({ fluid: val, breakpoint: '' }),
                        }),
                        !attributes.fluid &&
                            el(SelectControl, {
                                label: __('Max-width Breakpoint', 'wp-bootstrap-starter'),
                                value: attributes.breakpoint,
                                options: [
                                    { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                    { label: 'SM (540px)', value: 'sm' },
                                    { label: 'MD (720px)', value: 'md' },
                                    { label: 'LG (960px)', value: 'lg' },
                                    { label: 'XL (1140px)', value: 'xl' },
                                    { label: 'XXL (1320px)', value: 'xxl' },
                                ],
                                onChange: (val) => setAttributes({ breakpoint: val }),
                            })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        template: [['wpbs/row', {}]],
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // ROW BLOCK
    // =============================================================================
    registerBlockType('wpbs/row', {
        title: __('Bootstrap Row', 'wp-bootstrap-starter'),
        icon: 'columns',
        category: 'design',
        description: __('Bootstrap row voor kolommen layout.', 'wp-bootstrap-starter'),
        parent: ['wpbs/container'],
        supports: {
            html: false,
        },
        attributes: {
            template: { type: 'string', default: '1:1' },
            noGutters: { type: 'boolean', default: false },
            horizontalGutter: { type: 'string', default: '' },
            verticalGutter: { type: 'string', default: '' },
            verticalAlignment: { type: 'string', default: '' },
            horizontalAlignment: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            // Row templates
            const templates = {
                '1:1': [['wpbs/column', {}], ['wpbs/column', {}]],
                '1:2': [['wpbs/column', { sizeMd: '4' }], ['wpbs/column', { sizeMd: '8' }]],
                '2:1': [['wpbs/column', { sizeMd: '8' }], ['wpbs/column', { sizeMd: '4' }]],
                '1:1:1': [['wpbs/column', {}], ['wpbs/column', {}], ['wpbs/column', {}]],
                '1:1:1:1': [['wpbs/column', {}], ['wpbs/column', {}], ['wpbs/column', {}], ['wpbs/column', {}]],
                '1': [['wpbs/column', { sizeMd: '12' }]],
            };

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Row Instellingen', 'wp-bootstrap-starter') },
                        el(SelectControl, {
                            label: __('Template', 'wp-bootstrap-starter'),
                            value: attributes.template,
                            options: [
                                { label: '1 Kolom', value: '1' },
                                { label: '2 Kolommen (1:1)', value: '1:1' },
                                { label: '2 Kolommen (1:2)', value: '1:2' },
                                { label: '2 Kolommen (2:1)', value: '2:1' },
                                { label: '3 Kolommen', value: '1:1:1' },
                                { label: '4 Kolommen', value: '1:1:1:1' },
                            ],
                            onChange: (val) => setAttributes({ template: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Geen Gutters', 'wp-bootstrap-starter'),
                            checked: attributes.noGutters,
                            onChange: (val) => setAttributes({ noGutters: val }),
                        }),
                        !attributes.noGutters &&
                            el(
                                Fragment,
                                null,
                                el(SelectControl, {
                                    label: __('Horizontale Gutter', 'wp-bootstrap-starter'),
                                    value: attributes.horizontalGutter,
                                    options: [
                                        { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                        { label: '0', value: '0' },
                                        { label: '1', value: '1' },
                                        { label: '2', value: '2' },
                                        { label: '3', value: '3' },
                                        { label: '4', value: '4' },
                                        { label: '5', value: '5' },
                                    ],
                                    onChange: (val) => setAttributes({ horizontalGutter: val }),
                                }),
                                el(SelectControl, {
                                    label: __('Verticale Gutter', 'wp-bootstrap-starter'),
                                    value: attributes.verticalGutter,
                                    options: [
                                        { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                        { label: '0', value: '0' },
                                        { label: '1', value: '1' },
                                        { label: '2', value: '2' },
                                        { label: '3', value: '3' },
                                        { label: '4', value: '4' },
                                        { label: '5', value: '5' },
                                    ],
                                    onChange: (val) => setAttributes({ verticalGutter: val }),
                                })
                            ),
                        el(SelectControl, {
                            label: __('Verticale Uitlijning', 'wp-bootstrap-starter'),
                            value: attributes.verticalAlignment,
                            options: [
                                { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                { label: __('Start', 'wp-bootstrap-starter'), value: 'start' },
                                { label: __('Center', 'wp-bootstrap-starter'), value: 'center' },
                                { label: __('End', 'wp-bootstrap-starter'), value: 'end' },
                            ],
                            onChange: (val) => setAttributes({ verticalAlignment: val }),
                        }),
                        el(SelectControl, {
                            label: __('Horizontale Uitlijning', 'wp-bootstrap-starter'),
                            value: attributes.horizontalAlignment,
                            options: [
                                { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                { label: __('Start', 'wp-bootstrap-starter'), value: 'start' },
                                { label: __('Center', 'wp-bootstrap-starter'), value: 'center' },
                                { label: __('End', 'wp-bootstrap-starter'), value: 'end' },
                                { label: __('Between', 'wp-bootstrap-starter'), value: 'between' },
                                { label: __('Around', 'wp-bootstrap-starter'), value: 'around' },
                                { label: __('Evenly', 'wp-bootstrap-starter'), value: 'evenly' },
                            ],
                            onChange: (val) => setAttributes({ horizontalAlignment: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        allowedBlocks: ['wpbs/column'],
                        template: templates[attributes.template] || templates['1:1'],
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // COLUMN BLOCK
    // =============================================================================
    registerBlockType('wpbs/column', {
        title: __('Bootstrap Column', 'wp-bootstrap-starter'),
        icon: 'align-center',
        category: 'design',
        description: __('Bootstrap kolom met responsive breakpoints.', 'wp-bootstrap-starter'),
        parent: ['wpbs/row'],
        supports: {
            html: false,
        },
        attributes: {
            sizeXs: { type: 'string', default: '' },
            sizeSm: { type: 'string', default: '' },
            sizeMd: { type: 'string', default: '' },
            sizeLg: { type: 'string', default: '' },
            sizeXl: { type: 'string', default: '' },
            sizeXxl: { type: 'string', default: '' },
            offsetXs: { type: 'string', default: '' },
            offsetSm: { type: 'string', default: '' },
            offsetMd: { type: 'string', default: '' },
            offsetLg: { type: 'string', default: '' },
            offsetXl: { type: 'string', default: '' },
            offsetXxl: { type: 'string', default: '' },
            order: { type: 'string', default: '' },
            verticalAlignment: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const sizeOptions = [
                { label: __('Auto', 'wp-bootstrap-starter'), value: '' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '5', value: '5' },
                { label: '6', value: '6' },
                { label: '7', value: '7' },
                { label: '8', value: '8' },
                { label: '9', value: '9' },
                { label: '10', value: '10' },
                { label: '11', value: '11' },
                { label: '12', value: '12' },
            ];

            const offsetOptions = [
                { label: __('Geen', 'wp-bootstrap-starter'), value: '' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '5', value: '5' },
                { label: '6', value: '6' },
                { label: '7', value: '7' },
                { label: '8', value: '8' },
                { label: '9', value: '9' },
                { label: '10', value: '10' },
                { label: '11', value: '11' },
            ];

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Kolom Breedte', 'wp-bootstrap-starter') },
                        ['Xs', 'Sm', 'Md', 'Lg', 'Xl', 'Xxl'].map((bp) =>
                            el(SelectControl, {
                                key: bp,
                                label: bp.toUpperCase(),
                                value: attributes['size' + bp],
                                options: sizeOptions,
                                onChange: (val) => setAttributes({ ['size' + bp]: val }),
                            })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Kolom Offset', 'wp-bootstrap-starter'), initialOpen: false },
                        ['Xs', 'Sm', 'Md', 'Lg', 'Xl', 'Xxl'].map((bp) =>
                            el(SelectControl, {
                                key: bp,
                                label: bp.toUpperCase(),
                                value: attributes['offset' + bp],
                                options: offsetOptions,
                                onChange: (val) => setAttributes({ ['offset' + bp]: val }),
                            })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Extra Opties', 'wp-bootstrap-starter'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Volgorde', 'wp-bootstrap-starter'),
                            value: attributes.order,
                            options: [
                                { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                { label: 'First', value: 'first' },
                                { label: '1', value: '1' },
                                { label: '2', value: '2' },
                                { label: '3', value: '3' },
                                { label: '4', value: '4' },
                                { label: '5', value: '5' },
                                { label: 'Last', value: 'last' },
                            ],
                            onChange: (val) => setAttributes({ order: val }),
                        }),
                        el(SelectControl, {
                            label: __('Verticale Uitlijning', 'wp-bootstrap-starter'),
                            value: attributes.verticalAlignment,
                            options: [
                                { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                { label: __('Start', 'wp-bootstrap-starter'), value: 'start' },
                                { label: __('Center', 'wp-bootstrap-starter'), value: 'center' },
                                { label: __('End', 'wp-bootstrap-starter'), value: 'end' },
                            ],
                            onChange: (val) => setAttributes({ verticalAlignment: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // BUTTON BLOCK
    // =============================================================================
    registerBlockType('wpbs/button', {
        title: __('Bootstrap Button', 'wp-bootstrap-starter'),
        icon: 'button',
        category: 'design',
        description: __('Bootstrap button met alle stijlopties.', 'wp-bootstrap-starter'),
        supports: {
            html: false,
        },
        attributes: {
            text: { type: 'string', default: 'Button' },
            url: { type: 'string', default: '#' },
            style: { type: 'string', default: 'primary' },
            size: { type: 'string', default: '' },
            outline: { type: 'boolean', default: false },
            block: { type: 'boolean', default: false },
            disabled: { type: 'boolean', default: false },
            newTab: { type: 'boolean', default: false },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            let btnClass = 'btn';
            if (attributes.outline) {
                btnClass += ' btn-outline-' + attributes.style;
            } else {
                btnClass += ' btn-' + attributes.style;
            }
            if (attributes.size) {
                btnClass += ' btn-' + attributes.size;
            }
            if (attributes.block) {
                btnClass += ' d-block w-100';
            }
            if (attributes.disabled) {
                btnClass += ' disabled';
            }

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Button Instellingen', 'wp-bootstrap-starter') },
                        el(TextControl, {
                            label: __('Tekst', 'wp-bootstrap-starter'),
                            value: attributes.text,
                            onChange: (val) => setAttributes({ text: val }),
                        }),
                        el(TextControl, {
                            label: __('URL', 'wp-bootstrap-starter'),
                            value: attributes.url,
                            onChange: (val) => setAttributes({ url: val }),
                        }),
                        el(SelectControl, {
                            label: __('Stijl', 'wp-bootstrap-starter'),
                            value: attributes.style,
                            options: [
                                { label: 'Primary', value: 'primary' },
                                { label: 'Secondary', value: 'secondary' },
                                { label: 'Success', value: 'success' },
                                { label: 'Danger', value: 'danger' },
                                { label: 'Warning', value: 'warning' },
                                { label: 'Info', value: 'info' },
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' },
                                { label: 'Link', value: 'link' },
                            ],
                            onChange: (val) => setAttributes({ style: val }),
                        }),
                        el(SelectControl, {
                            label: __('Grootte', 'wp-bootstrap-starter'),
                            value: attributes.size,
                            options: [
                                { label: __('Standaard', 'wp-bootstrap-starter'), value: '' },
                                { label: __('Klein', 'wp-bootstrap-starter'), value: 'sm' },
                                { label: __('Groot', 'wp-bootstrap-starter'), value: 'lg' },
                            ],
                            onChange: (val) => setAttributes({ size: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Outline Stijl', 'wp-bootstrap-starter'),
                            checked: attributes.outline,
                            onChange: (val) => setAttributes({ outline: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Volledige Breedte', 'wp-bootstrap-starter'),
                            checked: attributes.block,
                            onChange: (val) => setAttributes({ block: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Uitgeschakeld', 'wp-bootstrap-starter'),
                            checked: attributes.disabled,
                            onChange: (val) => setAttributes({ disabled: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Open in nieuw tabblad', 'wp-bootstrap-starter'),
                            checked: attributes.newTab,
                            onChange: (val) => setAttributes({ newTab: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'a',
                        { className: btnClass, href: '#', onClick: (e) => e.preventDefault() },
                        attributes.text
                    )
                )
            );
        },

        save: function () {
            return null; // Rendered via PHP
        },
    });

    // =============================================================================
    // ALERT BLOCK
    // =============================================================================
    registerBlockType('wpbs/alert', {
        title: __('Bootstrap Alert', 'wp-bootstrap-starter'),
        icon: 'warning',
        category: 'design',
        description: __('Bootstrap alert melding.', 'wp-bootstrap-starter'),
        supports: {
            html: false,
        },
        attributes: {
            type: { type: 'string', default: 'primary' },
            dismissible: { type: 'boolean', default: false },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            let alertClass = 'alert alert-' + attributes.type;
            if (attributes.dismissible) {
                alertClass += ' alert-dismissible';
            }

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Alert Instellingen', 'wp-bootstrap-starter') },
                        el(SelectControl, {
                            label: __('Type', 'wp-bootstrap-starter'),
                            value: attributes.type,
                            options: [
                                { label: 'Primary', value: 'primary' },
                                { label: 'Secondary', value: 'secondary' },
                                { label: 'Success', value: 'success' },
                                { label: 'Danger', value: 'danger' },
                                { label: 'Warning', value: 'warning' },
                                { label: 'Info', value: 'info' },
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' },
                            ],
                            onChange: (val) => setAttributes({ type: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Wegklikbaar', 'wp-bootstrap-starter'),
                            checked: attributes.dismissible,
                            onChange: (val) => setAttributes({ dismissible: val }),
                        })
                    )
                ),
                el(
                    'div',
                    { ...blockProps, className: blockProps.className + ' ' + alertClass, role: 'alert' },
                    el(InnerBlocks, { templateLock: false }),
                    attributes.dismissible &&
                        el('button', {
                            type: 'button',
                            className: 'btn-close',
                            'aria-label': __('Sluiten', 'wp-bootstrap-starter'),
                        })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // CARD BLOCK
    // =============================================================================
    registerBlockType('wpbs/card', {
        title: __('Bootstrap Card', 'wp-bootstrap-starter'),
        icon: 'id-alt',
        category: 'design',
        description: __('Bootstrap card component.', 'wp-bootstrap-starter'),
        supports: {
            html: false,
        },
        attributes: {
            headerText: { type: 'string', default: '' },
            footerText: { type: 'string', default: '' },
            imageUrl: { type: 'string', default: '' },
            imagePosition: { type: 'string', default: 'top' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Card Instellingen', 'wp-bootstrap-starter') },
                        el(TextControl, {
                            label: __('Header Tekst', 'wp-bootstrap-starter'),
                            value: attributes.headerText,
                            onChange: (val) => setAttributes({ headerText: val }),
                        }),
                        el(TextControl, {
                            label: __('Footer Tekst', 'wp-bootstrap-starter'),
                            value: attributes.footerText,
                            onChange: (val) => setAttributes({ footerText: val }),
                        }),
                        el(TextControl, {
                            label: __('Afbeelding URL', 'wp-bootstrap-starter'),
                            value: attributes.imageUrl,
                            onChange: (val) => setAttributes({ imageUrl: val }),
                        }),
                        attributes.imageUrl &&
                            el(SelectControl, {
                                label: __('Afbeelding Positie', 'wp-bootstrap-starter'),
                                value: attributes.imagePosition,
                                options: [
                                    { label: __('Boven', 'wp-bootstrap-starter'), value: 'top' },
                                    { label: __('Onder', 'wp-bootstrap-starter'), value: 'bottom' },
                                ],
                                onChange: (val) => setAttributes({ imagePosition: val }),
                            })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'card' },
                        attributes.imageUrl &&
                            attributes.imagePosition === 'top' &&
                            el('img', { src: attributes.imageUrl, className: 'card-img-top', alt: '' }),
                        attributes.headerText &&
                            el('div', { className: 'card-header' }, attributes.headerText),
                        el('div', { className: 'card-body' }, el(InnerBlocks, { templateLock: false })),
                        attributes.footerText &&
                            el('div', { className: 'card-footer' }, attributes.footerText),
                        attributes.imageUrl &&
                            attributes.imagePosition === 'bottom' &&
                            el('img', { src: attributes.imageUrl, className: 'card-img-bottom', alt: '' })
                    )
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);
