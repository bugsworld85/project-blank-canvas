## About This Project

Let's face it, I couldn't really disclose whom this project is for. But one thing's for certain, somebody might need this code snippet which I am glad to share.

This is a blank [Wordpress](https://wordpress.org/) theme derived from [Blank Canvas](https://wordpress.com/theme/blank-canvas). I don't hold any rights on this theme. It's just for a short term mini project. Credits to its creators. All I did was inject VueJS into it. That's it.

## Features

- Enable the use of [Vuejs](https://vuejs.org/) Components.
- Have the capability of using npm packages to your [Wordpress](https://wordpress.org/) application.

## Pre-Requisites
- Make sure [Wordpress 5+](https://wordpress.org/) is installed with database and is already running on a localhost or remote server.
- Make sure [Seedlet](https://wordpress.org/themes/seedlet/) theme is installed as [Blank Canvas](https://wordpress.com/theme/blank-canvas) seems to be a child of that theme. You can search and install it within `Appearance->Themes` page or download it from [Wordpress themes library](https://wordpress.org/themes).
- Make sure **Day and name** is checked in `Settings->Permalinks` page.

## Installation

There are 2 ways to install this theme into your [Wordpress](https://wordpress.org/) application.

#### Option 1:

``` bash
$ cd <your-wordpress-dir>/wp-content/themes
$ git clone git@github.com:bugsworld85/project-blank-canvas.git blank-canvas
```
#### Option 2:

Download this repository from [Github](https://github.com/bugsworld85/project-blank-canvas) and upload it via `Appearance->Themes` in your WP admin dashboard.

**Note:** Do not forget to activate the theme within `Appearance->Themes` 

***

## Setup Sample Page

- create a page with WP native blocks in this structure:
    ``` bash
    Page Content
    ├─Columns
    │   └─ Column #[class: top-section]
    │       ├─ H1 Heading #[align: center, class: font-lora, color: white ]
    │       └─ Paragraph #[align: center, class: font-montserrat, color: white]
    ├─Columns #[class: donation-block]
    │   └─ Column #[class: donation-box-container]
    │       └─ Shortcode [donation-box]
    ├─Columns #[class: two-column-section]
    │   ├─ Column
    │   │   └─ Image #[class: border-radius-sm]
    │   └─ Column #[class: donation-block-quote]
    │       ├─ H5 Heading #[class: font-lora]
    │       └─ Paragraph #[class: font-montserrat]
    └─ Paragraph
    ```
  **Note on the above structure:** The lines right after `#` are page block settings which are mandatory.
- Make sure *Donation Template* is selected in the **Template** section within the current page's settings on the right side of your screen.
- Set the page you created above as your **FrontEnd** page.

***

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
