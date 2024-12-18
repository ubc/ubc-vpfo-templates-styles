const { InspectorControls } = wp.blockEditor || wp.editor;
const { PanelBody, DatePicker, ToggleControl } = wp.components;
const { createHigherOrderComponent } = wp.compose;
const { addFilter } = wp.hooks;

// Add new attributes for expiryDate and neverExpire.
const addCustomAttributes = (settings, name) => {
	if (name === 'core/quote') {
		settings.attributes = {
			...settings.attributes,
			expiryDate: {
				type: 'string',
				default: null, // Default to no expiry date.
			},
			neverExpire: {
				type: 'boolean',
				default: true, // Default to "Never Expire".
			},
		};
	}
	return settings;
};

addFilter(
	'blocks.registerBlockType',
	'custom/quote-block-custom-attributes',
	addCustomAttributes
);

// Add UI controls for expiry date and "Never Expire" toggle.
const withCustomControls = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { attributes, setAttributes, name } = props;

		if (name === 'core/quote') {
			return (
				<>
					<BlockEdit {...props} />
					<InspectorControls>
						<PanelBody title="Block Settings" initialOpen={true}>
							<h3 style={{ marginBottom: '10px' }}>Expiry Date</h3>
							<ToggleControl
								label="Never Expire"
								checked={attributes.neverExpire}
								onChange={(value) => setAttributes({ neverExpire: value })}
							/>
							{!attributes.neverExpire && (
								<DatePicker
									currentDate={attributes.expiryDate}
									onChange={(newDate) => setAttributes({ expiryDate: newDate })}
									__nextRemoveHelpButton={true} // Removes unnecessary help button.
								/>
							)}
						</PanelBody>
					</InspectorControls>
				</>
			);
		}

		return <BlockEdit {...props} />;
	};
}, 'withCustomControls');

addFilter(
	'editor.BlockEdit',
	'custom/with-quote-block-controls',
	withCustomControls
);

// Ensure the attributes are saved as part of the block's rendered output.
const saveCustomAttributes = (extraProps, blockType, attributes) => {
	if (blockType.name === 'core/quote') {
		if (attributes.expiryDate) {
			extraProps['data-expiry-date'] = attributes.expiryDate;
		}
		if (attributes.neverExpire) {
			extraProps['data-never-expire'] = attributes.neverExpire;
		}
	}
	return extraProps;
};

addFilter(
	'blocks.getSaveContent.extraProps',
	'custom/quote-block-custom-save-attributes',
	saveCustomAttributes
);