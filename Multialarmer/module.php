<?
// Klassendefinition
class Multialarmer extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
 
        $this->createLimitEnprofile();

        $this->RegisterPropertyInteger("VisuId",0);
        $this->RegisterPropertyInteger("ValueId01",0);
        $this->RegisterPropertyInteger("ValueId02",0);
        $this->RegisterPropertyInteger("ValueId03",0);
        $this->RegisterPropertyInteger("ValueId04",0);

        $this->RegisterVariableBoolean("NotifyEn01", "Variable 01 Melden?","LimitEn",95);
        $this->EnableAction("NotifyEn01");
        $this->RegisterVariableBoolean("NotifyEn02", "Variable 02 Melden?","LimitEn",115);
        $this->EnableAction("NotifyEn02");
        $this->RegisterVariableBoolean("NotifyEn03", "Variable 03 Melden?","LimitEn",135);
        $this->EnableAction("NotifyEn03");
        $this->RegisterVariableBoolean("NotifyEn04", "Variable 04 Melden?","LimitEn",155);
        $this->EnableAction("NotifyEn04");

        SetValue($this->RegisterVariableString("NotifyTitel01", "Titel der Benachrichtigung Var 01","~TextBox",100),"Störung!");
        $this->EnableAction("NotifyTitel01");

        SetValue($this->RegisterVariableString("NotifyTitel02", "Titel der Benachrichtigung Var 02","~TextBox",120),"Störung!");
        $this->EnableAction("NotifyTitel02");

        SetValue($this->RegisterVariableString("NotifyTitel03", "Titel der Benachrichtigung Var 03","~TextBox",140),"Störung!");
        $this->EnableAction("NotifyTitel03");

        SetValue($this->RegisterVariableString("NotifyTitel04", "Titel der Benachrichtigung Var 04","~TextBox",160),"Störung!");
        $this->EnableAction("NotifyTitel04");

    /*  
        SetValue($this->RegisterVariableString("NotifyText01", "Störungstext Var 01","~TextBox",110),"Störung 1");
        $this->EnableAction("NotifyText01");

        SetValue($this->RegisterVariableString("NotifyText02", "Störungstext Var 02","~TextBox",130),"Störung 2");
        $this->EnableAction("NotifyText02");

        SetValue($this->RegisterVariableString("NotifyText03", "Störungstext Var 03","~TextBox",150),"Störung 3");
        $this->EnableAction("NotifyText03");

        SetValue($this->RegisterVariableString("NotifyText04", "Störungstext Var 04","~TextBox",170),"Störung 4");
        $this->EnableAction("NotifyText04");
    */


        $this->RegisterTimer("Update", 0, 'VTMA_checkValues('.$this->InstanceID.');');
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();

        $this->SetTimerInterval("Update", 5 * 1000);

    }


    public function createLimitEnprofile(){
        if(!IPS_VariableProfileExists ("LimitEn") ){

            IPS_CreateVariableProfile("LimitEn", 0);
            IPS_SetVariableProfileAssociation("LimitEn", true, "Ja", "", 0x00FF00);
            IPS_SetVariableProfileAssociation("LimitEn", false, "Nein", "", 0xFFFF00);
        }
    }
    public function RequestAction($Ident, $Value) {
                $varid = $this->GetIDForIdent($Ident);
                SetValue($varid, $Value);

            
                $this->checkValues();
    }


    public function checkValues(){
        $webId  = $this->ReadPropertyInteger("VisuId"); 

        $IdVariable01 = $this->ReadPropertyInteger("ValueId01");

        $IdVariable02 = $this->ReadPropertyInteger("ValueId02");

        $IdVariable03 = $this->ReadPropertyInteger("ValueId03");

        $IdVariable04 = $this->ReadPropertyInteger("ValueId04");

        $NotifyEn01 = GetValue($this->GetIDForIdent("NotifyEn01"));
        $NotifyEn02 = GetValue($this->GetIDForIdent("NotifyEn02"));
        $NotifyEn03 = GetValue($this->GetIDForIdent("NotifyEn03"));
        $NotifyEn04 = GetValue($this->GetIDForIdent("NotifyEn04"));


        $NotifyTitel01 = GetValue($this->GetIDForIdent("NotifyTitel01"));
        $NotifyText01 = IPS_GetName($IdVariable01);//GetValue($this->GetIDForIdent("NotifyText01")); 	2.207.168.165/29

        $NotifyTitel02 = GetValue($this->GetIDForIdent("NotifyTitel02"));
        $NotifyText02 = IPS_GetName($IdVariable02);//GetValue($this->GetIDForIdent("NotifyText02"));

        $NotifyTitel03 = GetValue($this->GetIDForIdent("NotifyTitel03"));
        $NotifyText03 = IPS_GetName($IdVariable03);//GetValue($this->GetIDForIdent("NotifyText03"));

        $NotifyTitel04 = GetValue($this->GetIDForIdent("NotifyTitel04"));
        $NotifyText04 = IPS_GetName($IdVariable04);//GetValue($this->GetIDForIdent("NotifyText04"));


        if($NotifyEn01 == true && $IdVariable01 > 0){
            $value01 = GetValue($IdVariable01);

            $this->notify($IdVariable01, $webId, $IdVariable01, $NotifyTitel01, $NotifyText01, "Flame");

        }

        if($NotifyEn02 == true && $IdVariable02 > 0){
            $value02 = GetValue($IdVariable02);

            $this->notify($IdVariable02, $webId, $IdVariable02, $NotifyTitel02, $NotifyText02, "Flame");

        }

        if($NotifyEn03 == true && $IdVariable03 > 0){
            $value03 = GetValue($IdVariable03);

            $this->notify($IdVariable03, $webId, $IdVariable03, $NotifyTitel03, $NotifyText03, "Flame");

        }

        if($NotifyEn04 == true && $IdVariable04 > 0){
            $value04 = GetValue($IdVariable04);

            $this->notify($IdVariable04, $webId, $IdVariable04, $NotifyTitel04, $NotifyText04, "Flame");

        }


    }

    public function setInitValues(){
        SetValue($this->GetIDForIdent("NotifyTitel01"),"Störung!");

        SetValue($this->GetIDForIdent("NotifyTitel02"),"Störung!");

        SetValue($this->GetIDForIdent("NotifyTitel03"),"Störung!");

        SetValue($this->GetIDForIdent("NotifyTitel04"),"Störung!");
    }

    private function notify($trigid, $webfrontid, $targetid, $art, $smname, $ico){

        if (GetValueBoolean($trigid) == true && ($this->GetBuffer($smname) == "true"))  {
            
            $this->SetBuffer($smname, "false");   

            VISU_PostNotification($webfrontid, $art, $smname, $ico, $targetid);
            
        }
        elseif (GetValueBoolean($trigid) == false) {
            $this->SetBuffer($smname, "true");
        }

        if (GetValueBoolean($trigid) == true){
            return true; 
        }else{
            return false;
        }
    }

}

?>