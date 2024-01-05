<?
// Klassendefinition
class ModCreator extends IPSModule {
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();
        
        $this->RegisterPropertyInteger("PropertyCategoryID");
        $this->RegisterPropertyInteger("PropertyGatewayID");
        $this->RegisterPropertyInteger("PropertyMediaID");

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
    private function createModobject($socket, $catId, $objectName,$adressread,$fcread, $adresswrite, $fcwrite, $datatype,$factor) {
   

        $newInstance = IPS_CreateInstance("{CB197E50-273D-4535-8C91-BB35273E3CA5}");
        IPS_DisconnectInstance($newInstance);
        IPS_ConnectInstance($newInstance, $socket);
        IPS_SetName($newInstance, $objectName);

        IPS_SetConfiguration($newInstance, '{"ReadFunctionCode":'.$fcread.',"WriteFunctionCode":'.$fcwrite.',"Factor":'.$factor.',"DataType":'.$datatype.',"WriteAddress":'.$adresswrite.',"ReadAddress":'.$adressread.'}');
        IPS_ApplyChanges($newInstance);

        IPS_SetParent($newInstance, $catId);
        IPS_ApplyChanges($newInstance);


    }

    public function createModobjects(){
     
        $idCat = $this->ReadPropertyInteger("PropertyCategoryID");
        $idGw = $this->ReadPropertyInteger("PropertyGatewayID");
        $idMedia = $this->ReadPropertyInteger("PropertyMediaID");

        $csv = base64_decode(IPS_GetMediaContent($idMedia));


        while (($data = str_getcsv($csv)) !== FALSE) {

            $row++;
      
      
              if ($row>2){                     
            //createModobject($socket, $catId, $objectName,$adressread, $fcread, $adresswrite,  $fcwrite, $datatype,    $factor)
                createModobject($idGw, $idCat, $data[0],    $data[1],   $data[2], $data[3],     $data[4], $data[5],     $data[6]);
              }
      

    }
}
?>