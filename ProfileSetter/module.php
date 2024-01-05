<?
// Klassendefinition
class ProfileSetter extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
        
        $this->RegisterPropertyInteger("PropertyCategoryID",0);
        $this->RegisterPropertyString("PropertyProfileNameBool","~Switch");
        $this->RegisterPropertyString("PropertyProfileNameInt","~Intensity.100");
        $this->RegisterPropertyString("PropertyProfileNameFloat","~Temperature");
        $this->RegisterPropertyString("PropertyProfileNameString","~TextBox");

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
    public function setProfile() {
   
        $idKat = $this->ReadPropertyInteger("PropertyCategoryID");
        $katChilds = IPS_GetChildrenIDs($idKat);
        
        foreach ($katChilds as $katChild) {
            $chilid = IPS_GetChildrenIDs($katChild)[0];
            $parentname = IPS_GetName($katChild);

            $payload = GetValue($chilid);
            // determine data type
            if(is_string($payload)) {
                $ips_var_type = 3;
                $profile = $this->ReadPropertyString("PropertyProfileNameString");  
            } else if(is_float($payload)) {
                $ips_var_type = 2;
                $profile = $this->ReadPropertyString("PropertyProfileNameFloat");  
            } else if(is_int($payload)) {
                $ips_var_type = 1;
                $profile = $this->ReadPropertyString("PropertyProfileNameInt");  
            } else if(is_bool($payload)) {
                $ips_var_type = 0;
                $profile = $this->ReadPropertyString("PropertyProfileNameBool");  
            } else { // unsupported
                return false;
            }            
            
            IPS_SetVariableCustomProfile($chilid, $profile);

            }       
       
        }


    
}
?>