<?PHP 
    Header("content-type: application/x-javascript");

    /* * * define the site path * * */
    $site_path = realpath(dirname(__FILE__).'/../..').'/';
    define('__SITE_PATH', $site_path); 

    /* * * define the application path * * */
    define('__APPLICATION_PATH', __SITE_PATH.'application/');

    /* * * define the admin path * * */
    $admin_path = realpath(dirname(__FILE__).'/..').'/';
    define('__ADMIN_PATH', $admin_path);

    /* * * define the config path * * */
    define('__CONFIG_PATH', __APPLICATION_PATH.'config/');

    require(__APPLICATION_PATH.'core/Database.php');
    require(__APPLICATION_PATH.'core/Settings.php');
    OPC_Settings::init();

    require(__APPLICATION_PATH.'lib/Language.php');
    function lang() {
        return Language::getInstance();
    }
    lang()->addSystemLangFile('common');
?>

function PopUp(p_innerHTML){
    var innerHTML   = p_innerHTML;
    var buttons     = new Array();
    this.width      = 400; 

    this.addButton = function(url, name, buttonColor){
        var button          = {};
        button.url          = url;
        button.name         = name;
        button.buttonColor  = buttonColor;
        buttons.push(button);
    }

    this.display = function() {
        var content         = document.createElement("div");
        content.id          = "popupContent";
        content.innerHTML   = innerHTML;

        var buttonsDiv  = document.createElement("div");
        buttonsDiv.id   = "popupButtons";
        var buttonsHTML = "";
        for (var i = 0; i < buttons.length; i++) {
            but = buttons[i];
            buttonsHTML += " <a href='"+but.url+"' class='button "+but.buttonColor+"'>"+but.name+"</a>";
        }
        buttonsHTML += " <a class='button bluebut' onclick='removePopUp();' href='#'><?PHP echo lang()->get('common_cancel'); ?></a>";
        buttonsDiv.innerHTML = buttonsHTML;

        var popup               = document.createElement("div");
        popup.id                = 'popup';
        popup.style.width       = this.width+"px";
        popup.style.marginRight = "-"+((this.width/2)+15)+"px";
        popup.appendChild(content);
        popup.appendChild(buttonsDiv);
        
        var popupOverlay    = document.createElement("div");
        popupOverlay.id     = 'popupOverlay';
        popupOverlay.appendChild(popup);
        document.body.appendChild(popupOverlay);
    }

}

function removePopUp(){
    popup = document.getElementById("popupOverlay");
    popup.parentNode.removeChild(popup);
}