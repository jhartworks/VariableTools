<?
// Klassendefinition
class MinMax extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
        $this->createHystprofile();
        $this->createLimitprofile();
        $this->createLimitEnprofile();

        $this->RegisterPropertyInteger("VisuId",0);
        $this->RegisterPropertyInteger("ValueId",0);

        SetValue($this->RegisterVariableFloat("ActualValue", "Aktueller Wert","",0),123.4);

        SetValue($this->RegisterVariableFloat("MinValue", "Minimalwert","LimitValue",10),20);
        $this->EnableAction("MinValue");
        SetValue($this->RegisterVariableBoolean("MinValueEn", "Minimalwert auswerten?","LimitEn",20),true);
        $this->EnableAction("MinValueEn");
        $this->RegisterVariableBoolean("IsMinValue", "Minimalwert","~Alert",30);

        SetValue($this->RegisterVariableFloat("MaxValue", "Maximalwert","LimitValue",50),70);
        $this->EnableAction("MaxValue");
        SetValue($this->RegisterVariableBoolean("MaxValueEn", "Maximalwert auswerten?","LimitEn",60),true);
        $this->EnableAction("MaxValueEn");
        $this->RegisterVariableBoolean("IsMaxValue", "Maximalwert","~Alert",70);

        SetValue($this->RegisterVariableFloat("Hysterese", "Hysterese","Hysteresis",80),1);
        $this->EnableAction("Hysterese");

        SetValue($this->RegisterVariableBoolean("NotifyEn", "Benachrichtigen?","LimitEn",100),true);
        $this->EnableAction("NotifyEn");

        SetValue($this->RegisterVariableString("NotifyTitel", "Titel der Benachrichtigung","~TextBox",100),"Störung!");
        $this->EnableAction("NotifyTitel");

        SetValue($this->RegisterVariableString("NotifyTextMin", "Text bei Min","~TextBox",120),"Grenzwert unterschritten");
        $this->EnableAction("NotifyTextMin");
        SetValue($this->RegisterVariableString("NotifyTextMax", "Text bei Max","~TextBox",140),"Grenzwert überschritten");
        $this->EnableAction("NotifyTextMax");


        $this->RegisterTimer("Update", 0, 'VTMM_checkValues('.$this->InstanceID.');');
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();

        $this->SetTimerInterval("Update", 10 * 1000);

    }


    public function createHystprofile(){
        if(!IPS_VariableProfileExists ("Hysteresis") ){
            IPS_CreateVariableProfile("Hysteresis", 2);
            IPS_SetVariableProfileDigits ("Hysteresis", 1);
            IPS_SetVariableProfileValues("Hysteresis", -20,20,0.5);
        }
    }
    public function createLimitprofile(){
        if(!IPS_VariableProfileExists ("LimitValue") ){
            IPS_CreateVariableProfile("LimitValue", 2);
            IPS_SetVariableProfileDigits ("LimitValue", 0);
            IPS_SetVariableProfileValues("LimitValue", -350,350,1);
        }
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
        $valueId = $this->ReadPropertyInteger("ValueId");
        $value = GetValue($valueId);

        $ActualValueId = $this->GetIDForIdent("ActualValue");

        SetValue($ActualValueId,$value);

        $MinValue = GetValue($this->GetIDForIdent("MinValue"));
        $MaxValue = GetValue($this->GetIDForIdent("MaxValue"));
        $Hysterese = GetValue($this->GetIDForIdent("Hysterese"));

        $NotifyEn = GetValue($this->GetIDForIdent("NotifyEn"));

        $MinValueEn = GetValue($this->GetIDForIdent("MinValueEn"));
        $MaxValueEn = GetValue($this->GetIDForIdent("MaxValueEn"));

        $IsMinValueId = $this->GetIDForIdent("IsMinValue");
        $IsMaxValueId = $this->GetIDForIdent("IsMaxValue");

        if ($MinValueEn == true){

            if($value + $Hysterese < $MinValue){
                SetValue($IsMinValueId,true);
            }
            if($value - $Hysterese > $MinValue){
                SetValue($IsMinValueId,false);
            }

        }else
        {
           SetValue($IsMinValueId,false);
        }

        if ($MaxValueEn == true){

            if($value - $Hysterese > $MaxValue){
                SetValue($IsMaxValueId,true);
            }
            if($value + $Hysterese < $MaxValue){
                SetValue($IsMaxValueId,false);
            }

        }else
        {
           SetValue($IsMaxValueId,false);
        }

        $webId  = $this->ReadPropertyInteger("VisuId");
        $NotifyTitel = GetValue($this->GetIDForIdent("NotifyTitel"));
        $NotifyTextMin = GetValue($this->GetIDForIdent("NotifyTextMin"));
        $NotifyTextMax = GetValue($this->GetIDForIdent("NotifyTextMax"));


        if($NotifyEn == true){

            $this->notify($IsMinValueId, $webId, $IsMinValueId, $NotifyTitel, $NotifyTextMin, "Snowflake");
            $this->notify($IsMaxValueId, $webId, $IsMaxValueId, $NotifyTitel, $NotifyTextMax, "Flame");

        }



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