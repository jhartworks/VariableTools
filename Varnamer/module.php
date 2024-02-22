<?
// Klassendefinition
class Varnamer extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();


        $this->RegisterPropertyInteger("IdVariable01",0);
        $this->RegisterPropertyInteger("IdVariable02",0);
        $this->RegisterPropertyInteger("IdVariable03",0);
        $this->RegisterPropertyInteger("IdVariable04",0);



        SetValue($this->RegisterVariableString("Name01", "Name Variable 1","~TextBox",10),"Variable 1");
        $this->EnableAction("Name01");
        SetValue($this->RegisterVariableString("Name02", "Name Variable 2","~TextBox",10),"Variable 2");
        $this->EnableAction("Name02");
        SetValue($this->RegisterVariableString("Name03", "Name Variable 3","~TextBox",10),"Variable 3");
        $this->EnableAction("Name03");
        SetValue($this->RegisterVariableString("Name04", "Name Variable 4","~TextBox",10),"Variable 4");
        $this->EnableAction("Name04");





    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();

    }
    public function RequestAction($Ident, $Value) {
                $varid = $this->GetIDForIdent($Ident);
                SetValue($varid, $Value);

            
                $this->checkValues();
    }


    public function checkValues(){
        $Idvalue01 = $this->ReadPropertyInteger("IdVariable01");
        $Idvalue02 = $this->ReadPropertyInteger("IdVariable02");
        $Idvalue03 = $this->ReadPropertyInteger("IdVariable03");
        $Idvalue04 = $this->ReadPropertyInteger("IdVariable04");

        $Name01 = GetValue($this->GetIDForIdent("Name01"));
        $Name02 = GetValue($this->GetIDForIdent("Name02"));
        $Name03 = GetValue($this->GetIDForIdent("Name03"));
        $Name04 = GetValue($this->GetIDForIdent("Name04"));

        if ($Idvalue01 > 0){
            IPS_SetName($Idvalue01, $Name01);
        }
        if ($Idvalue02 > 0){
            IPS_SetName($Idvalue02, $Name02);
        }
        if ($Idvalue03 > 0){
            IPS_SetName($Idvalue03, $Name03);
        }
        if ($Idvalue04 > 0){
            IPS_SetName($Idvalue04, $Name04);
        }

    }


}

?>