<?
// Klassendefinition
class Renamer extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
        
        $this->RegisterPropertyInteger("PropertyCategoryID",0);
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();
    }
    /**
    * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
    * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
    *
    *
    */
    public function rename() {
   
        $idKat = $this->ReadPropertyInteger("PropertyCategoryID");
        $katChilds = IPS_GetChildrenIDs($idKat);
        
        foreach ($katChilds as $katChild) {
            $chilid = IPS_GetChildrenIDs($katChild)[0];
            $parentname = IPS_GetName($katChild);
            $childname = $parentname;
            IPS_SetName($chilid,$childname);       
            }       
       
    }


}
?>