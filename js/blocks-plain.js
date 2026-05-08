/* Pirumatic - Plain Flavor Block */

var 
	el                = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	PlainText         = wp.blockEditor.PlainText,
	__                = wp.i18n.__;
	
registerBlockType('pirumatic/blocks', {
		
	title    : 'Pirumatic',
	icon     : el('svg', { width: 24, height: 24, viewBox: '0 0 24 24' },
					el('path', { d: 'm23.134 8.64-5.973-3.62a.286.286 0 0 0-.412.125l-1.4 3.286 2.842 1.696a.53.53 0 0 1 0 .921l-5.335 3.14-2.267 5.274a.127.127 0 0 0 .052.203.12.12 0 0 0 .134-.035l3.914-2.365 1.545 2.219a.37.37 0 0 0 .309.167h3.708a.37.37 0 0 0 .327-.2.38.38 0 0 0-.018-.386l-2.513-3.852 5.088-3.077q.865-.524.865-1.172V9.813q0-.649-.866-1.172zM13.082 4.35.845 12.052q-.865.523-.845 1.171v1.173q.021.648.866 1.15l6.056 3.496a.286.286 0 0 0 .412-.146l1.36-3.286-2.884-1.633a.52.52 0 0 1-.275-.384.53.53 0 0 1 .254-.537l5.295-3.245 2.183-5.316a.13.13 0 0 0-.04-.142.12.12 0 0 0-.146-.005z' })
				),
	category : 'formatting',
	keywords : [ 
		__('code',      'pirumatic'), 
		__('pre',       'pirumatic'), 
		__('prism',     'pirumatic'), 
		__('highlight', 'pirumatic'), 
		__('pirumatic', 'pirumatic') 
	],
	transforms : {
		from : [
			{
				type   : 'block',
				blocks : [ 'core/code' ],
				transform : function(attributes) {
					return wp.blocks.createBlock('pirumatic/blocks', {
						content : attributes.content,
					});
				},
			},
		],
		to : [
			{
				type   : 'block',
				blocks : [ 'core/code' ],
				transform : function(attributes) {
					return wp.blocks.createBlock('core/code', {
						content : attributes.content,
					});
				},
			},
		],
	},
	attributes : {
		content : {
			type     : 'string',
			source   : 'text',
			selector : 'pre code',
		},
		backgroundColor : {
			type    : 'string',
			default : '',
		},
		textColor : {
			type    : 'string',
			default : '',
		},
	},
	
	edit : function(props) {
		
		var 
			content         = props.attributes.content,
			backgroundColor = props.attributes.backgroundColor,
			textColor       = props.attributes.textColor,
			className       = props.className,
			isSelected      = props.isSelected;

		function onChangeContent(newValue) {
			props.setAttributes({ content: newValue });
		}
		
		return (isSelected) ? 
			el(
				PlainText,
				{
					tagName     : 'pre',
					key         : 'editable',
					placeholder : __('Add code..', 'pirumatic'),
					className   : className,
					onChange    : onChangeContent,
					style       : { backgroundColor : backgroundColor || undefined, color : textColor || undefined },
					value       : content,
				}
			) : 
			el(
				'pre',
				{
					className : className,
					style     : { backgroundColor : backgroundColor || undefined, color : textColor || undefined },
				},
				el('code', null, content || __('(empty code block)', 'pirumatic'))
			);
		
	},
	
	save : function(props) {
		return el('pre', null, el('code', null, props.attributes.content));
	},
		
});