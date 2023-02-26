<?php
use classes\Settings;

require plugin_dir_path(__FILE__) . 'classes/Settings.php';

// Check if the required class exists
if (!class_exists('classes\Settings')) {
    exit('The Settings class is missing.');
}

// Create an instance of the Settings class
$settings = new Settings();


// Include the required class files

if (isset($_POST['submit-test'])) {
    // Validate and set the object properties
    $settings->temperatureValue = (filter_input(INPUT_POST, 'temperatureValue', FILTER_VALIDATE_FLOAT) / 100) ?? '';
    $settings->apiToken = filter_input(INPUT_POST, 'apiToken', FILTER_SANITIZE_STRING) ?? '';
    $settings->maxTokens = filter_input(INPUT_POST, 'maxTokens', FILTER_VALIDATE_INT)  ?? '';
    $settings->selectLanguage = filter_input(INPUT_POST, 'selectLanguage', FILTER_SANITIZE_STRING) ?? '';
    $settings->updateOrInsert();
    // Call the method to update or insert the settings

}

function imgPath($path){
    return plugin_dir_url(__FILE__).'img/assets/'.$path;
}

$languages = ["ua","en"];
if(in_array($settings->language,$languages)) {
    include plugin_dir_path(__FILE__)."language/".$settings->language.".php";
} else {
    include plugin_dir_path(__FILE__)."language/en.php";
}

?>

<section class="settings">
    <div class="container">
        <div class="settings__logo-box"><a class="settings__logo" href="/"><img class="settings__logo-img" src="<?= imgPath('logo.png');?>" alt="logo GPT WriteGenie"></a></div>
        <div class="settings__wrap" style="background-image: url('<?= imgPath('bg.jpg')?>')">
            <h2 class="settings__title"><?php echo $lang["settings"]?></h2>
            <div class="settings__inner">
                <form class="settings__form" method="POST"><label class="settings__label">Chat GPT <input class="settings__input setting__api" name="apiToken" placeholder="API Token (sk-xxxxx)"  value="<?= $settings->getTableData()[0]->api_token ?? ''?>" required></label> <label class="settings__label settings__label--hidden" for="">
                        <div class="settings__label_wrapper"><span><?php echo $lang["temperature"]?></span>
                            <div class="settings__hint"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5 17.7083C12.7951 17.7083 13.0427 17.6083 13.2427 17.4083C13.442 17.209 13.5416 16.9618 13.5416 16.6667V12.474C13.5416 12.1788 13.442 11.9358 13.2427 11.7448C13.0427 11.5538 12.7951 11.4583 12.5 11.4583C12.2048 11.4583 11.9576 11.558 11.7583 11.7573C11.5583 11.9573 11.4583 12.2049 11.4583 12.5V16.6927C11.4583 16.9879 11.5583 17.2309 11.7583 17.4219C11.9576 17.6129 12.2048 17.7083 12.5 17.7083ZM12.5 9.37501C12.7951 9.37501 13.0427 9.27501 13.2427 9.07501C13.442 8.87571 13.5416 8.62848 13.5416 8.33334C13.5416 8.03821 13.442 7.79064 13.2427 7.59064C13.0427 7.39133 12.7951 7.29168 12.5 7.29168C12.2048 7.29168 11.9576 7.39133 11.7583 7.59064C11.5583 7.79064 11.4583 8.03821 11.4583 8.33334C11.4583 8.62848 11.5583 8.87571 11.7583 9.07501C11.9576 9.27501 12.2048 9.37501 12.5 9.37501ZM12.5 22.9167C11.059 22.9167 9.70484 22.6431 8.43748 22.0958C7.17012 21.5493 6.06769 20.8073 5.13019 19.8698C4.19269 18.9323 3.45067 17.8299 2.90415 16.5625C2.35692 15.2951 2.08331 13.941 2.08331 12.5C2.08331 11.059 2.35692 9.70487 2.90415 8.43751C3.45067 7.17015 4.19269 6.06772 5.13019 5.13022C6.06769 4.19272 7.17012 3.45036 8.43748 2.90314C9.70484 2.35661 11.059 2.08334 12.5 2.08334C13.941 2.08334 15.2951 2.35661 16.5625 2.90314C17.8298 3.45036 18.9323 4.19272 19.8698 5.13022C20.8073 6.06772 21.5493 7.17015 22.0958 8.43751C22.643 9.70487 22.9166 11.059 22.9166 12.5C22.9166 13.941 22.643 15.2951 22.0958 16.5625C21.5493 17.8299 20.8073 18.9323 19.8698 19.8698C18.9323 20.8073 17.8298 21.5493 16.5625 22.0958C15.2951 22.6431 13.941 22.9167 12.5 22.9167ZM12.5 20.8333C14.809 20.8333 16.7753 20.0219 18.3989 18.399C20.0219 16.7754 20.8333 14.809 20.8333 12.5C20.8333 10.191 20.0219 8.22466 18.3989 6.60105C16.7753 4.97814 14.809 4.16668 12.5 4.16668C10.191 4.16668 8.22498 4.97814 6.60206 6.60105C4.97845 8.22466 4.16665 10.191 4.16665 12.5C4.16665 14.809 4.97845 16.7754 6.60206 18.399C8.22498 20.0219 10.191 20.8333 12.5 20.8333Z" fill="white" /></svg>
                                <p class="settings__desc settings__desc--hidden"><?php echo $lang["temperatureText"]?></div>
                        </div>
                    </label>
                    <div class="range__wrapper">
                        <div class="form-slider"></div>
                        <div class="form-slider__text" id="slider-step-value"></div><input class="form-slider__child" name="temperatureValue"  value="<?= $settings->getTableData()[0]->temperature ?? 60 ?>" hidden>
                    </div><label class="settings__label">
                        <div class="settings__label_wrapper"><span class="setting__label-span"><?php echo $lang["maxTokens"]?></span>
                            <div class="settings__hint"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5 17.7083C12.7951 17.7083 13.0427 17.6083 13.2427 17.4083C13.442 17.209 13.5416 16.9618 13.5416 16.6667V12.474C13.5416 12.1788 13.442 11.9358 13.2427 11.7448C13.0427 11.5538 12.7951 11.4583 12.5 11.4583C12.2048 11.4583 11.9576 11.558 11.7583 11.7573C11.5583 11.9573 11.4583 12.2049 11.4583 12.5V16.6927C11.4583 16.9879 11.5583 17.2309 11.7583 17.4219C11.9576 17.6129 12.2048 17.7083 12.5 17.7083ZM12.5 9.37501C12.7951 9.37501 13.0427 9.27501 13.2427 9.07501C13.442 8.87571 13.5416 8.62848 13.5416 8.33334C13.5416 8.03821 13.442 7.79064 13.2427 7.59064C13.0427 7.39133 12.7951 7.29168 12.5 7.29168C12.2048 7.29168 11.9576 7.39133 11.7583 7.59064C11.5583 7.79064 11.4583 8.03821 11.4583 8.33334C11.4583 8.62848 11.5583 8.87571 11.7583 9.07501C11.9576 9.27501 12.2048 9.37501 12.5 9.37501ZM12.5 22.9167C11.059 22.9167 9.70484 22.6431 8.43748 22.0958C7.17012 21.5493 6.06769 20.8073 5.13019 19.8698C4.19269 18.9323 3.45067 17.8299 2.90415 16.5625C2.35692 15.2951 2.08331 13.941 2.08331 12.5C2.08331 11.059 2.35692 9.70487 2.90415 8.43751C3.45067 7.17015 4.19269 6.06772 5.13019 5.13022C6.06769 4.19272 7.17012 3.45036 8.43748 2.90314C9.70484 2.35661 11.059 2.08334 12.5 2.08334C13.941 2.08334 15.2951 2.35661 16.5625 2.90314C17.8298 3.45036 18.9323 4.19272 19.8698 5.13022C20.8073 6.06772 21.5493 7.17015 22.0958 8.43751C22.643 9.70487 22.9166 11.059 22.9166 12.5C22.9166 13.941 22.643 15.2951 22.0958 16.5625C21.5493 17.8299 20.8073 18.9323 19.8698 19.8698C18.9323 20.8073 17.8298 21.5493 16.5625 22.0958C15.2951 22.6431 13.941 22.9167 12.5 22.9167ZM12.5 20.8333C14.809 20.8333 16.7753 20.0219 18.3989 18.399C20.0219 16.7754 20.8333 14.809 20.8333 12.5C20.8333 10.191 20.0219 8.22466 18.3989 6.60105C16.7753 4.97814 14.809 4.16668 12.5 4.16668C10.191 4.16668 8.22498 4.97814 6.60206 6.60105C4.97845 8.22466 4.16665 10.191 4.16665 12.5C4.16665 14.809 4.97845 16.7754 6.60206 18.399C8.22498 20.0219 10.191 20.8333 12.5 20.8333Z" fill="white" /></svg>
                                <p class="settings__desc settings__desc--hidden"><?php echo $lang["maxTokensText"]?></div>
                        </div><input type='number' class="settings__input settings__token" name="maxTokens" placeholder="Max 4000" max="4000" value="<?= $settings->getTableData()[0]->max_tokens ?? 250 ?>">
                    </label> <label class="settings__label"><?php echo $lang["selectLanguage"]?></label> <select class="settings__label settings__lang" name="selectLanguage" value="">
                        <option class="settings__input" value="en" <?php echo ($settings->getTableData()[0]->language) == 'en' ? 'selected': ''  ?> >English US</option>
                        <option class="settings__input" value="ua" <?php echo ($settings->getTableData()[0]->language) == 'ua' ? 'selected': ''  ?> >Ukraine UA</option>
                    </select> <button class="settings__btn settings__btn-save" type="submit" name="submit-test"><?php echo $lang["saveSettings"]?></button>
                </form>
                <div class="settings__box-img"><img class="settings__img" src="<?= imgPath('brain.png"')?>" alt="big logo brain"></div>
            </div><span class="settings__version"><?php echo $lang["version"]?> 1.0</span>
        </div>
    </div>
</section>






