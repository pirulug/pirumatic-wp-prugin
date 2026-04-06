# Pirumatic

**Pirumatic** is a powerful and lightweight WordPress plugin for syntax highlighting code snippets in your posts, pages and comments. It's built to be fast, secure, and easy to use.

## Features

- **Multiple Libraries**: Choose between **Prism.js**, **Highlight.js**, or a simple **Plain Flavor** for your code.
- **Frontend & Backend Escaping**: Automatic escaping of code tags to prevent security issues and ensure correct display.
- **Highly Customizable**: 
  - Over 100+ themes for Highlight.js and multiple Prism.js themes.
  - Line numbers, line highlighting, and "Copy to Clipboard" functionality.
  - Show/Hide language labels.
- **Spanish Localization**: Fully translated to Spanish (es_ES).
- **Lightweight**: Only loads the necessary scripts and styles on pages where code is actually used.
- **No bloat**: No automated updates, no tracking, just a clean, functional plugin.

## Installation

1. Upload the `pirumatic` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the settings under **Settings > Pirumatic**.

## Usage

Simply wrap your code in `<pre><code>` tags:

```html
<pre><code class="language-javascript">
console.log('Hello, Pirumatic!');
</code></pre>
```

Or use the provided shortcode:

```text
[pirumatic_code class="language-python"]
print("Hello World")
[/pirumatic_code]
```

## Requirements

- **WordPress**: 4.7 or higher
- **PHP**: 5.6.20 or higher

## Changelog

### 0.0.1
- Initial release as **Pirumatic**.
- Licensed under MIT.
- Added full Spanish translation.
- Removed external promotional resources and author branding.
- Optimized initialization logic.

## License

This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for details.

---

*Powered by Pirulug*
