import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/C:laragonwwwinar-technologiesappFilamentClustersAditionalInformation**/*.php",
        "./resources/views/filament/c:laragonwwwinar-technologiesapp-filament-clusters-aditional-information**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/awcodes/filament-table-repeater/resources/**/*.blade.php",
        "./vendor/awcodes/filament-tiptap-editor/resources/**/*.blade.php",
    ],
};
