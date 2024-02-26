<?
// Klassendefinition
class Do8ToWord extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();


        $this->RegisterPropertyInteger("IdVariable",0);

        $this->RegisterVariableBoolean("Q01", "Ausgang 1","",10);
        $this->EnableAction("Q01");
        $this->RegisterVariableBoolean("Q02", "Ausgang 2","",20);
        $this->EnableAction("Q02");
        $this->RegisterVariableBoolean("Q03", "Ausgang 3","",30);
        $this->EnableAction("Q03");
        $this->RegisterVariableBoolean("Q04", "Ausgang 4","",40);
        $this->EnableAction("Q04");
        $this->RegisterVariableBoolean("Q05", "Ausgang 5","",50);
        $this->EnableAction("Q05");
        $this->RegisterVariableBoolean("Q06", "Ausgang 6","",60);
        $this->EnableAction("Q06");
        $this->RegisterVariableBoolean("Q07", "Ausgang 7","",70);
        $this->EnableAction("Q07");
        $this->RegisterVariableBoolean("Q08", "Ausgang 8","",80);
        $this->EnableAction("Q08");



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
        $Idvalue = $this->ReadPropertyInteger("IdVariable");


        $IdQ01 = $this->GetIDForIdent("Q01");
        $IdQ02 = $this->GetIDForIdent("Q02");
        $IdQ03 = $this->GetIDForIdent("Q03");
        $IdQ04 = $this->GetIDForIdent("Q04");
        $IdQ05 = $this->GetIDForIdent("Q05");
        $IdQ06 = $this->GetIDForIdent("Q06");
        $IdQ07 = $this->GetIDForIdent("Q07");
        $IdQ08 = $this->GetIDForIdent("Q08");



        $outputs[0]  = $this->GetValueBooleanNull($IdQ01);
        $outputs[1]  = $this->GetValueBooleanNull($IdQ02);
        $outputs[2]  = $this->GetValueBooleanNull($IdQ03);
        $outputs[3]  = $this->GetValueBooleanNull($IdQ04);
        $outputs[4]  = $this->GetValueBooleanNull($IdQ05);
        $outputs[5]  = $this->GetValueBooleanNull($IdQ06);
        $outputs[6]  = $this->GetValueBooleanNull($IdQ07);
        $outputs[7]  = $this->GetValueBooleanNull($IdQ08);


        $out = $this->binaryArrayToInt($outputs);
        RequestAction($Idvalue,$out);
    }

    public function binaryArrayToInt(ARRAY $bitsArray) {
        // Das Bit-Array umkehren, da es andersherum übergeben wird
        $reversedBitsArray = array_reverse($bitsArray);
    
        // Das umgekehrte Bit-Array in einen Binärstring konvertieren
        $binaryString = implode("", $reversedBitsArray);
    
        // Den Binärstring in eine Ganzzahl umwandeln
        $intValue = bindec($binaryString);
    
        return $intValue;
    }
    
    public function GetValueBooleanNull(INT $id)
    {
    if (GetValueBoolean($id) == 1){
        return 1;
    }else
    {
        return 0;
    }
    }



}

?>