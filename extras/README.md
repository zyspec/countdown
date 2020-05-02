![Countdown Module](../assets/images/logoModule.png)
# Countdown Module Templates for XOOPS
[![XOOPS CMS Module](https://img.shields.io/badge/XOOPS%20CMS-Module-blue.svg)](https://xoops.org)
[![Template License](https://img.shields.io/badge/license-CC%20BY-yellowgreen.svg?style=flat)](https://creativecommons.org/licenses/by/4.0/legalcode)

## Module Templates
> This module uses the following templates for display of information on the user (front) side:
* countdown_add.tpl - displays a form to collect user input for a new Countdown.
* countdown_edit.tpl - displays a form to collect user input to modify an existing Countdown.
* countdown_list.top - displays list of Countdowns

> These files are located in the ``/countdown/templates`` folder.

## Legacy Templates
> The module's legacy templates are included as the default templates for use with XOOPS. These templates include layout and CSS for display with the default and classic templates.
* These templates are used by default - the administrator/webmaster does not need to do anything to the XOOPS or module installation to use these templates.
* These templates may be used 'as-is'. Changes, if desired, may be made to the templates and/or theme CSS to modify the module's information display to meet the site's requirements. It is recommended the administrator use the XOOPS template interface in the XOOPS Admin panel (Admin->Modules->System->Templates) to modify module templates.

## Bootstrap Templates
> [Bootstrap](https://getbootstrap.com) is a jQuery component library to allow an administrator/designer to create a modern, responsive website theme.
  
> This module's bootstrap templates are minimalistic templates that may be used 'as-is' with existing XOOPS bootstrap themes. These templates use a combination of XOOPS CSS (``./xoops.css``) and CSS from the selected bootstrap theme. It may be desirable for the site administrator (designer) to make additional modifications to the template CSS to provide further customization. These templates must be "installed" into the desired theme's folder.

>The bootsrap templates are located in the module's `./extras/themes`. The folders follow a naming convention so the templates located in the `bootstrap3` folder are compatible with themes based on the bootstrap3 component library. Likewise, templates located in the `bootstrap4` folder are to be used with themes based on bootstrap 4.

>### Install Bootstrap Templates
>To use these templates the site administrator must follow these steps:
>#### Option I:
> If the administrator is planning to use Bootstrap enabled theme(s) only then the module's bootsrap templates can be copied directly into the module's templates folder. The advantage of this method is that the templates do not have to be copied to the modules folder for each theme used. There are a couple of disadvantages of this method however.
>* Using the <i>standard</i> update method of copying the module's folders on top of the existing folder will result in the templates being overwritten by the legacy templates during the update. This may, or may not, be the desired effect. This can be preevented by selectively copying files during future updates but care must be taken to only overwrite the desired files. Otherwise the steps outlined below will need to be repeated each time the module is updatad.
* Using this method the templates from the ``./modules/countdown/templates`` folder will be used for all themes. The administrator/designer will not be able to make changes to the templates based on the look-and-feel desired for each theme individually.
   
>__To use Option I - do the following:__
>1. Copy the contents of the `./countdown/extras/themes/bootstrap/modules/countdown` folder to the `./countdown/templates` folder.
2. To ensure the XOOPS installation begins to use the new templates it is a good idea to the clear smarty_cache and smarty_compile folders. To do this:
    1. Go to the Admin Panel and select 'Maintenance'.
    2. In the 'Maintenance' form select smarty_cache and smarty_compile.
    3. Select the 'Yes' option in the "Empty the sessions table" radio select.
    4. Select 'Submit' at the bottom of the 'Maintenance' form. 
3. Select the desired bootstrap theme and then navigate to the Coundown module pages.

>#### Option II: <i>(Recommended)</i>
> To provide the most flexibility and reduce risk of accidental change(s) to the boostrap templates the administrator/designer should copy the module templates folder to the desired theme(s) folder. The procedure below should be duplicated for each bootstrap theme that will be used. The advantages of using Option II is that the when the module is updated, the bootstrap templates in the theme folder will not be overwritten. Option II also allows the administrator to make customizations to optimize the templates for each theme used. The disadvantages of Option II are that it is a little more complex to setup.
 
>__To use Option II - do the following:__
> 1. Check the bootstrap theme's modules folder (for example - ``../themes/xswatch4/modules``) to see if the theme designer has already included templates for this module. This can be verified by looking for the module's name (in this case 'countdown'). If the theme already includes a ``'./modules/countdown'`` folder then you may want to use those templates instead of the templates included here. You can load the module normally and verify everything looks, and behaves, as expected.
2. Copy the ``./countdown/extras/themes/bootstrap/modules/countdown`` folder to the site theme folder (for example: ``./themes/xswatch4/modules``). The finished folder structure should be ``./themes/xswatch4/modules/countdown``
3. Ensure the desired theme is selectable in the XOOPS Admin panel (Admin->Preferences->System->Selectable themes) or it can be selected as the default if desired (Admin->Preferences->System->Default theme).
4. To ensure the XOOPS installation begins to use the new templates it is a good idea to clear smarty_cache and the smarty_compile folders. To do this:
    1. Go to the Admin Panel and select 'Maintenance'.
    2. In the 'Maintenance' form select smarty_cache and smarty_compile.
    3. Select the 'Yes' option in the "Empty the sessions table" radio select.
    4. Select 'Submit' at the bottom of the 'Maintenance' form. 
4. Select the desired bootstrap theme and then navigate to the Coundown module pages.

## Notes
>1. The bootstrap templates will not be updated automatically if the module is updated. The administrator must manually copy the module's bootstrap templates to the theme folder as [described above](#install-bootstrap-templates)
2. The `countdown_list.tpl` does use bootstrap to hide the date column on Small and smaller displays to minimize clutter. Obviously this is a design choice and can easily be 'undone' by the designer using CSS if desired.  

## How You Can Help
> If you make modifications you think would be useful for others, please tell someone. Comment in the forums on the [XOOPS website](https://xoops.org) or on the [Countdown Module Repository](https://github.com/XoopsModules25x/countdown) 

> If you're a theme designer please use the existing templates to improve on them for a new XOOPS theme and share them with the community.
