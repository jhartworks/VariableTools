<?
// Klassendefinition
class WordTo16Di extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();


        $this->RegisterPropertyInteger("IdVariable",0);

        $this->RegisterVariableBoolean("E01", "Eingang 1","",10);
        $this->RegisterVariableBoolean("E02", "Eingang 2","",20);
        $this->RegisterVariableBoolean("E03", "Eingang 3","",30);
        $this->RegisterVariableBoolean("E04", "Eingang 4","",40);
        $this->RegisterVariableBoolean("E05", "Eingang 5","",50);
        $this->RegisterVariableBoolean("E06", "Eingang 6","",60);
        $this->RegisterVariableBoolean("E07", "Eingang 7","",70);
        $this->RegisterVariableBoolean("E08", "Eingang 8","",80);
        $this->RegisterVariableBoolean("E09", "Eingang 9","",90);
        $this->RegisterVariableBoolean("E10", "Eingang 10","",100);
        $this->RegisterVariableBoolean("E11", "Eingang 11","",110);
        $this->RegisterVariableBoolean("E12", "Eingang 12","",120);
        $this->RegisterVariableBoolean("E13", "Eingang 13","",130);
        $this->RegisterVariableBoolean("E14", "Eingang 14","",140);
        $this->RegisterVariableBoolean("E15", "Eingang 15","",150);
        $this->RegisterVariableBoolean("E16", "Eingang 16","",160);

        $this->RegisterTimer("Update", 0, 'VTWD_checkValues('.$this->InstanceID.');');
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();

        $this->SetTimerInterval("Update", 1 * 1000);

    }
    public function RequestAction($Ident, $Value) {
                $varid = $this->GetIDForIdent($Ident);
                SetValue($varid, $Value);

            
                $this->checkValues();
    }


    public function checkValues(){
        $Idvalue = $this->ReadPropertyInteger("IdVariable");


        $IdE01 = $this->GetIDForIdent("E01");
        $IdE02 = $this->GetIDForIdent("E02");
        $IdE03 = $this->GetIDForIdent("E03");
        $IdE04 = $this->GetIDForIdent("E04");
        $IdE05 = $this->GetIDForIdent("E05");
        $IdE06 = $this->GetIDForIdent("E06");
        $IdE07 = $this->GetIDForIdent("E07");
        $IdE08 = $this->GetIDForIdent("E08");
        $IdE09 = $this->GetIDForIdent("E09");
        $IdE10 = $this->GetIDForIdent("E10");
        $IdE11 = $this->GetIDForIdent("E11");
        $IdE12 = $this->GetIDForIdent("E12");
        $IdE13 = $this->GetIDForIdent("E13");
        $IdE14 = $this->GetIDForIdent("E14");
        $IdE15 = $this->GetIDForIdent("E15");
        $IdE16 = $this->GetIDForIdent("E16");


        $inputs = $this->intTo16BitBinary(GetValue($Idvalue));
        SetValueBoolean($IdE01,$inputs[0]);
        SetValueBoolean($IdE02,$inputs[1]);
        SetValueBoolean($IdE03,$inputs[2]);
        SetValueBoolean($IdE04,$inputs[3]);
        SetValueBoolean($IdE05,$inputs[4]);
        SetValueBoolean($IdE06,$inputs[5]);
        SetValueBoolean($IdE07,$inputs[6]);
        SetValueBoolean($IdE08,$inputs[7]);
        SetValueBoolean($IdE09,$inputs[8]);
        SetValueBoolean($IdE10,$inputs[9]);
        SetValueBoolean($IdE11,$inputs[10]);
        SetValueBoolean($IdE12,$inputs[11]);
        SetValueBoolean($IdE13,$inputs[12]);
        SetValueBoolean($IdE14,$inputs[13]);
        SetValueBoolean($IdE15,$inputs[14]);
        SetValueBoolean($IdE16,$inputs[15]);

    }

    public function intTo16BitBinary(INT $number) {
        // Überprüfen, ob die Zahl im gültigen 16-Bit-Bereich liegt
        if ($number < 0 || $number > 65535) {
            return "Die Zahl liegt nicht im gültigen 16-Bit-Bereich.";
        }
    
        // Umwandlung in 16-Bit-Binärdarstellung
        $binary = decbin($number);
    
        // Auffüllen mit Nullen auf 16 Bits
        $paddedBinary = str_pad($binary, 16, '0', STR_PAD_LEFT);
    
        // Jedes Bit einzeln als Array ausgeben, aber umgekehrt
        $bitsArray = array_reverse(str_split($paddedBinary));
    
        return $bitsArray;
    }



}

?>