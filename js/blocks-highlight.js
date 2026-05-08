/* Pirumatic - Highlight.js Block */

var 
	el                = wp.element.createElement,
	Fragment          = wp.element.Fragment,
	registerBlockType = wp.blocks.registerBlockType,
	RichText          = wp.editor.RichText,
	PlainText         = wp.blockEditor.PlainText,
	RawHTML           = wp.editor.RawHTML,
	InspectorControls = wp.blockEditor.InspectorControls,
	SelectControl     = wp.components.SelectControl,
	applyFilters      = wp.hooks.applyFilters,
	__                = wp.i18n.__;

registerBlockType('pirumatic/blocks', {

	title    : 'Pirumatic',
	icon     : el('svg', { width: 24, height: 24, viewBox: '0 0 24 24' },
					el('path', { d: 'm23.134 8.64-5.973-3.62a.286.286 0 0 0-.412.125l-1.4 3.286 2.842 1.696a.53.53 0 0 1 0 .921l-5.335 3.14-2.267 5.274a.127.127 0 0 0 .052.203.12.12 0 0 0 .134-.035l3.914-2.365 1.545 2.219a.37.37 0 0 0 .309.167h3.708a.37.37 0 0 0 .327-.2.38.38 0 0 0-.018-.386l-2.513-3.852 5.088-3.077q.865-.524.865-1.172V9.813q0-.649-.866-1.172zM13.082 4.35.845 12.052q-.865.523-.845 1.171v1.173q.021.648.866 1.15l6.056 3.496a.286.286 0 0 0 .412-.146l1.36-3.286-2.884-1.633a.52.52 0 0 1-.275-.384.53.53 0 0 1 .254-.537l5.295-3.245 2.183-5.316a.13.13 0 0 0-.04-.142.12.12 0 0 0-.146-.005z' })
				),
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
		language : {
			type    : 'string',
			default : '',
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
			language        = props.attributes.language,
			backgroundColor = props.attributes.backgroundColor,
			textColor       = props.attributes.textColor,
			className       = props.className,
			isSelected      = props.isSelected,
			languages       = [
				{ label : 'Language..',    value : '' },
				
				{ label : 'Apache',        value : 'apache' },
				{ label : 'AppleScript',   value : 'applescript' },
				{ label : 'Arduino',       value : 'arduino' },
				{ label : 'AVR Assembler', value : 'avrasm' },
				{ label : 'Awk',           value : 'awk' },
				{ label : 'Bash',          value : 'bash' },
				{ label : 'C',             value : 'c' },
				{ label : 'CoffeeScript',  value : 'coffeescript' },
				{ label : 'C++',           value : 'cpp' },
				{ label : 'C#',            value : 'cs' },
				{ label : 'CSS',           value : 'css' },
				{ label : 'D',             value : 'd' },
				{ label : 'Dart',          value : 'dart' },
				{ label : 'Diff',          value : 'diff' },
				{ label : 'Elixir',        value : 'elixir' },
				{ label : 'G-code',        value : 'gcode' },
				{ label : 'GML',           value : 'gml' },
				{ label : 'Go',            value : 'go' },
				{ label : 'GraphQL',       value : 'graphql' },
				{ label : 'Groovy',        value : 'groovy' },
				{ label : 'HTTP',          value : 'http' },
				{ label : 'Ini/TOML',      value : 'ini' },
				{ label : 'Java',          value : 'java' },
				{ label : 'JavaScript',    value : 'javascript' },
				{ label : 'JSON',          value : 'json' },
				{ label : 'Julia',         value : 'julia' },
				{ label : 'Kotlin',        value : 'kotlin' },
				{ label : 'LaTeX',         value : 'tex' },
				{ label : 'Less',          value : 'less' },
				{ label : 'Lua',           value : 'lua' },
				{ label : 'Makefile',      value : 'makefile' },
				{ label : 'Markdown',      value : 'markdown' },
				{ label : 'Matlab',        value : 'matlab' },
				{ label : 'Nginx',         value : 'nginx' },
				{ label : 'Objective-C',   value : 'objectivec' },
				{ label : 'Perl',          value : 'perl' },
				{ label : 'PHP',           value : 'php' },
				{ label : 'PHP Template',  value : 'php-template' },
				{ label : 'Plaintext',     value : 'plaintext' },
				{ label : 'PowerShell',    value : 'powershell' },
				{ label : 'Properties',    value : 'properties' },
				{ label : 'Python',        value : 'python' },
				{ label : 'Python REPL',   value : 'python-repl' },
				{ label : 'R',             value : 'r' },
				{ label : 'Ruby',          value : 'ruby' },
				{ label : 'Rust',          value : 'rust' },
				{ label : 'SAS',           value : 'sas' },
				{ label : 'Scala',         value : 'scala' },
				{ label : 'SCSS',          value : 'scss' },
				{ label : 'Shell Session', value : 'shell' },
				{ label : 'SQL',           value : 'sql' },
				{ label : 'Swift',         value : 'swift' },
				{ label : 'TypeScript',    value : 'typescript' },
				{ label : 'VB.Net',        value : 'vbnet' },
				{ label : 'Verilog',       value : 'verilog' },
				{ label : 'VHDL',          value : 'vhdl' },
				{ label : 'Vim Script',    value : 'vim' },
				{ label : 'XML/HTML',      value : 'xml' },
				{ label : 'YAML',          value : 'yaml' },
			];
			
		function onChangeContent(newValue) {
			props.setAttributes({ content: newValue });
		}
		
		function onChangelanguage(newValue) {
			props.setAttributes({ language: newValue });
		}
		
		var displayContent = (isSelected) ? 
			el(
				PlainText,
				{
					tagName     : 'pre',
					key         : 'editable',
					placeholder : __('Add code..', 'pirumatic'),
					className   : className + ' language-' + language,
					onChange    : onChangeContent,
					style       : { backgroundColor : backgroundColor || undefined, color : textColor || undefined },
					value       : content,
				}
			) : 
			el(
				'pre',
				{
					className : className + ' language-' + language,
					style     : { backgroundColor : backgroundColor, color : textColor },
				},
				el('code', null, content || __('(empty code block)', 'pirumatic'))
			);

		return (
			el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						SelectControl,
						{
							label    : __('Select Language for Highlight.js', 'pirumatic'),
							value    : language,
							onChange : onChangelanguage,
							options  : applyFilters('pirumaticHighlightMenu', languages),
						}
					)
				),
				displayContent
			)
		);
	},
	
	save : function(props) {
		
		var 
			content  = props.attributes.content,
			language = props.attributes.language;
		
		return el('pre', null, el('code', { className: 'language-'+ language }, content));
		
	},
});