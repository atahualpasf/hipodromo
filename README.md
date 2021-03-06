Introducción
============

**HipódromoASAC** -- nace como un sistema de gestión para el "Hipódromo La Rinconada", contemplando todo lo relacionado al mundo hípico. El sistema debe gestionar los ejemplares, entrenadores, studs, propietarios, apuestas, carreras, programa oficial, inscripciones, resultados, implementos de carreras, veterinarios de las cuadras, medicamentos aplicados antes de las carreras y con la capacidad de escalar e implementar más cosas no definidas hasta ahora. Con vista al futuro, pensamos que dicho sistema pueda ser consultado a través de la web por "nuestros aficionados", de esta manera ellos podrán ver el historial de cada ejemplar en específico, el programa oficial y los resultados de los programas anteriores. El sistema por lo tanto fué desarrollado contemplando el uso de usuarios y roles. 

!["Hipódromo"] (https://github.com/atahualpasf/hipodromo/blob/master/dist/img/presentation/presentation-ejemplares-01.png "Hipódromo Presentación")

**HipódromoASAC** está basado en la plantilla(template) **[AdminLTE 2.3.0](https://github.com/almasaeed2010/AdminLTE)** que a su vez tiene como base  **[Bootstrap 3](https://github.com/twbs/bootstrap)** framework. Es altamente recomendable dicho template ya que es muy fácil de usar, es muy intuitivo y sobre todo que es altamente personalizable y adaptativo para todo tipo de pantallas (Responsive).

El **sistema de administración del Hipódromo** cuenta con varias funcionabilidades como:
* Registro y manejo de usuarios con sus roles. (Próximamente CRUD de privilegios).
* Validación de acceso a ciertos módulos de la aplicación según sus privilegios.
* CRUDS:
  * Caballerizas o cuadras (Desarrollando).
  * Studs (Desarrollando).
  * Propietarios (Desarrollando).
  * Jinetes (Desarrollando).
  * Inscripciones (Desarrollando).
  * Entrenadores (Desarrollando).
  * Ejemplares (Desarrollando).
  * Apuestas (Desarrollando).
  * Usuario (Desarrollando).
  * Reportes (Desarrollando).

Este sistema de administración de hipódromo ha sido desarrollado como un proyecto en colaboración con: 
* **[Andrea Contreras - @andrecontdi](https://github.com/andrecontdi)**. 

También cuenta la participación menor de dos programadores en desarrollo:
* Juan Silva.
* Sabina Quiroga.

Installation
------------
There are multiple ways to install AdminLTE.

####Download:

Download from Github or [visit Almsaeed Studio](https://almsaeedstudio.com) and download the latest release.

####Using The Command Line:

**Github**

- Fork the repository ([here is the guide](https://help.github.com/articles/fork-a-repo/)).
- Clone to your machine
```
git clone https://github.com/YOUR_USERNAME/AdminLTE.git
```

**Bower**

```
bower install admin-lte
```

**Composer**

```
composer require "almasaeed2010/adminlte=~2.0"
```

Documentation
-------------
Visit the [online documentation](https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html) for the most
updated guide. Information will be added on a weekly basis.

Compatibilidad con navegadores
---------------
- Edge
- Chrome (latest)

Contribution
------------
Contribution are always **welcome and recommended**! Here is how:

- Fork the repository ([here is the guide](https://help.github.com/articles/fork-a-repo/)).
- Clone to your machine ```git clone https://github.com/YOUR_USERNAME/AdminLTE.git```
- Make your changes
- Create a pull request

#### Contribution Requirements:

- When you contribute, you agree to give a non-exclusive license to Almsaeed Studio to use that contribution in any context as we (Almsaeed Studio) see appropriate.
- If you use content provided by another party, it must be appropriately licensed using an [open source](http://opensource.org/licenses) license.
- Contributions are only accepted through Github pull requests.
- Finally, contributed code must work in all supported browsers (see above for browser support).

License
-------
HipódromoASAC es un proyecto de código abierto realizado por [Atahualpa Silva F. - @atahualpasf](https://github.com/atahualpasf) y [Andrea Contreras - @andrecontdi](https://github.com/andrecontdi) el cuál esá licensiado bajo [MIT](http://opensource.org/licenses/MIT). atahualpasf reserva el derecho de cambiar la licencia en futuras versiones.

Todo List
---------
- ~~Light sidebar colors~~ (Done v2.1.0)
- ~~Right sidebar~~ (Done v2.1.0)
- ~~Minified main-sidebar~~ (Done v2.1.0)
- Right to left support
- Custom pace style

Change log
----------
**v2.3.0:**
- Added social widgets (found in the widgets page)
- Added profile page
- Fix issue #430 (requires ```.hold-transition``` to be added to ```<body>```)
- Fix issue #578
- Fix issue #579

**v2.2.1:**
- Bug Fixes
- Removed many ```!important``` statements in css
- Activate boxWidget automatically when created after the page has loaded
- Activate sidebar menu treeview links automatically when created after the page has loaded
- Updated Font Awesome thanks to @Dennis14e
- Added JSHint to Grunt tasks (Find JS errors)
- Added CSSLint to Grunt tasks (Find CSS errors)
- Added Image to Grunt tasks (compress images)
- Added Clean to Grunt tasks (remove unwanted files like uncompressed images)
- Updated Bootstrap to 3.3.5

**v2.2.0:**
- Bug fixes
- Added support for [Select2](https://select2.github.io/)
- Updated ChartJS

**v2.1.2:**
- Added explicit BoxWidget activation function issue #450
- Crushed some bugs

**v2.1.1:**
- Fix version error

**v2.1.0:**
- Update Ion Icons
- Added right sidebar ```.control-sidebar```
- Control sidebar has 2 open effects: slide over content and push content
- Control sidebar converts to always slide over content on small screens
- Added 6 new light sidebar skins
- Updated demo menu
- Added ChartJS preview page
- Fixed some minor bugs
- Added light control sidebar skin
- Added expand on hover option for sidebar mini
- Added fixed control sidebar layout

**v2.0.5:**
- Fixed issue #288

**v2.0.4:**
- Fixed bower.json to pick up newest release.

**v2.0.3**
- Bug fixes
- Fixed extra page when printing issue #264
- Updated documentation and fixed links scrolling issue
- Created print.less file (this makes it easier if you want to create a seperate CSS file for printing)
- Fixed sidebar stretching issue #275
- Fixed checkbox out of bounds issue in WYSIHTML5 editor.

**v2.0.2:**
- Solved issue with hidden arrow in select inputs.

**v2.0.1:**
- Updated README.md
- Fixed versioning issue in CSS, LESS, and JS
- Updated box-shadow for boxes
- Updated docs

**v2.0.0:**

- Major layout bug fixes
- Change in layout mark up
- Added transitions to the sidebar
- New skins and modified previous skins
- Change in color scheme to a more complementing scheme
- Added footer support
- Removed pace.js from the main app.js
- Added support for collapsed sidebar as an initial state (add .sidebar-collapse to the body tag)
- Added boxed layout (.layout-boxed)
- Enhanced consistency in padding and margining
- Updated Bootstrap to 3.3.2
- Fixed navbar dropdown menu on small screens positioning issues.
- Updated Ion Icons to 2.0.0
- Updated FontAwesome to 4.3.0
- Added ChartJS 1.0.1
- Removed iCheck dependency
- Created Dashboard 2.0
- Created new Chat widget (DirectChat)
- Added transitions to DirectChat
- Added contacts pane to DirectChat
- Changed .right-side to .content-wrapper
- Changed .navbar-right to .navbar-custom-menu
- Removed unused files
- Updated lockscreen style (HTML markup changed!)
- Updated Login & Registration pages (HTML markup changed!)
- Updated buttons style.
- Enhanced border-radius consistency
- Added mailbox: inbox, read, and compose pages
- Bootstrap & jQuery are now hosted locally
- Created documentation.

**ver 1.2.0:**

- Fixed the sidebar scroll issue when using the fixed layout.
- Added [Bootstrap Social Buttons](http://lipis.github.io/bootstrap-social/ "Bootstrap Social") plugin.
- Fixed RequireJS bug. Thanks to [StaticSphere](https://github.com/StaticSphere "github user").

**ver 1.1.0:**

- Added new skin. class: .skin-black
- Added [pace](http://github.hubspot.com/pace/docs/welcome/ "pace") plugin.

Image Credits
-------------
[Pixeden](http://www.pixeden.com/psd-web-elements/flat-responsive-showcase-psd)

[Graphicsfuel](http://www.graphicsfuel.com/2013/02/13-high-resolution-blur-backgrounds/)

[Pickaface](http://pickaface.net/)

[Unsplash](https://unsplash.com/)

[Uifaces](http://uifaces.com/)

Donations
---------
Donations are **greatly appreciated!**

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif "AdminLTE Presentation")](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=629XCUSXBHCBC "Donate")
