<?
// Klassendefinition
class ModCreator extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
        
        $this->RegisterPropertyInteger("PropertyCategoryID",0);
        $this->RegisterPropertyInteger("PropertyGatewayID",0);
        $this->RegisterPropertyInteger("PropertyMediaID",0);
        $this->RegisterPropertyInteger("PropertyObjectSortOffset",0);

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
    private function createModobject($socket, $catId, $pos, $objectName,$adressread,$fcread, $adresswrite, $fcwrite, $datatype,$factor,$byteorder) {
   

        $newInstance = IPS_CreateInstance("{CB197E50-273D-4535-8C91-BB35273E3CA5}");
        IPS_DisconnectInstance($newInstance);
        IPS_ConnectInstance($newInstance, $socket);
        IPS_SetName($newInstance, $objectName);

        IPS_SetConfiguration($newInstance, '{"ByteOrder":'.$byteorder.',"DataType":'.$datatype.',"EmulateStatus":true,"Factor":'.$factor.',"Poller":1000,"ReadAddress":'.$adressread.',"ReadFunctionCode":'.$fcread.',"WriteAddress":'.$adresswrite.',"WriteFunctionCode":'.$fcwrite.'}');
        IPS_SetPosition($newInstance,$pos);
        IPS_ApplyChanges($newInstance);

        IPS_SetParent($newInstance, $catId);
        IPS_ApplyChanges($newInstance);


    }

    public function createModobjects(){
     
        $idCat = $this->ReadPropertyInteger("PropertyCategoryID");
        $idGw = $this->ReadPropertyInteger("PropertyGatewayID");
        $idMedia = $this->ReadPropertyInteger("PropertyMediaID");
        $sortoffset = $this->ReadPropertyInteger("PropertyObjectSortOffset");

        $csv = base64_decode(IPS_GetMediaContent($idMedia));
        // Zeilen in ein Array aufteilen
        $lines = explode(PHP_EOL, $csv);

        // Anzahl der Zeilen ermitteln
        $totalLines = count($lines);
       // echo $totalLines;
        // Durch jede Zeile der CSV-Datei iterieren mit einem for loop
        for ($row = 1; $row < $totalLines-1; $row++) {
        // CSV-Zeile in ein Array von Daten aufteilen
        $data = str_getcsv($lines[$row], ";", "\"", "\\");

        // Überprüfen, ob es sich um die Kopfzeile oder eine Datenzeile handelt
        if ($row > 0) {
            // Hier kannst du die Modobject-Funktion mit den entsprechenden Indizes aus dem $data-Array aufrufen
           //error_reporting(0);
            $this->createModobject($idGw, $idCat, $row + $sortoffset, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6],$data[7]);

            // Beispiel-Ausgabe des ersten Elements in jeder Zeile
               // print_r($data[7]);
        }
    }

    }
}
?>