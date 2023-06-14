<?php
namespace Rscharitas\MVCPCARE\Model;
use Rscharitas\MVCPCARE\App\Connection;

class PendaftaranModel {
    private string $kode = "BPJ0001";

            public function queryantrian()
            {
                //start_query
                $conn = new Connection();

                $arr = [];

                $query = $conn->select("r.RegistrationDate as tgldftr, r.GuarantorCardNo as nokartu, r.ServiceUnitID as kdpoli, r.GuarantorID as guarantorid, p.Ssn AS nik,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr INNER JOIN PatientHealthRecordLine phrl ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo AND phrl.QuestionID IN ('KDV.TDR.S', 'REST.06', 'A.KDV.TDS', 'IOP.HR.S', 'trg4.01')
                                        ORDER BY phrl.LastUpdateDateTime DESC) as siastole,
                                        ( SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('A.KDV.TDD', 'IOP.HR.D', 'KDV.TDR.D', 'REST.05', 'trg4.02')
                                        ORDER BY phrl.LastUpdateDateTime DESC
                                        ) as diastole,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl 
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('akktv13', 'bbank', 'bbyi', 'BRTBD', 'NUT.BB', 'QMCU0035', 'RJ.N.BBA')
                                        ORDER BY phrl.LastUpdateDateTime DESC 
                                        ) as berat_badan,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl 
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('akktv14', 'NUT.TB', 'QMCU0034', 'RJ.N.TBA', 'tbank', 'TGBDN')
                                        ORDER BY phrl.LastUpdateDateTime DESC 
                                        ) as tinggi_badan,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl 
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('MINT1.0101', 'RJ.N.LLP')
                                        ORDER BY phrl.LastUpdateDateTime DESC 
                                        ) as lingkar_perut,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl 
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('A.RES.RS', 'RES.FREQ')
                                        ORDER BY phrl.LastUpdateDateTime DESC 
                                        ) as frekuensi_pernapasan,
                                        (SELECT TOP 1 phrl.QuestionAnswerNum 
                                        FROM PatientHealthRecord phr 
                                        INNER JOIN PatientHealthRecordLine phrl 
                                        ON phrl.TransactionNo = phr.TransactionNo 
                                        WHERE phr.RegistrationNo = r.RegistrationNo 
                                        AND phrl.QuestionID IN ('KDV.DYT', 'QMCU0038')
                                        ORDER BY phrl.LastUpdateDateTime DESC ) as detak_jantung")
                              ->from("Registration r")
                              ->innerJoin('Patient p', 'p.PatientID = r.PatientID')
                              ->where([
                                "r.GuarantorID = '$this->kode'",
                                "r.GuarantorCardNo != '' ",
                                "p.Ssn != '' "
                                ])
                              ->top(50)
                              ->execute();
                            
                  return $query;
            }

            public function tesmodel()
            {
               // echo json_encode($query);

                // $query2 = $conn->select('')



                // $query = "SELECT TOP 1000 r.RegistrationDate as Tanggal_Daftar,
                //                         r.GuarantorCardNo as NoKartu, 
                //                         r.ServiceUnitID as KodePoli, 
                //                         r.GuarantorID as GuarantorID, 
                //                         r.GuarantorCardNo as GuarantorCardNo FROM Registration r where r.GuarantorID = '$this->kode' 
                //                         and r.GuarantorCardNo is not null";
                // $reslt = $conn->execute($query);
                // while ($row = odbc_fetch_array($reslt)) {
                //     $response = $row;
                //     echo json_encode($row);
                // }
                
                // end_query


                // $conn->executeQuery($query, null, "Unknown Error");
                // $listdata = $conn->fetchArrayListEx();

                // for ($i=0; $i<count($listdata) ; $i++) { 
                //     $a = $listdata[$i];
                //     $i++;
                // }
                
                // start_query
                // $query2 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr INNER JOIN PatientHealthRecordLine phrl ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo AND phrl.QuestionID IN ('KDV.TDR.S', 'REST.06', 'A.KDV.TDS', 'IOP.HR.S', 'trg4.01')
                //            ORDER BY phrl.LastUpdateDateTime DESC ) as siastole 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                
                // $reslt2 = $conn->execute($query2);
                // while ($row2 = odbc_fetch_array($reslt2)) {
                //     $response2 = $row2;
                // }
                // end_query



                // $conn->executeQuery($query2, null, "Unknown Error");
                // $listdata2 = $conn->fetchArrayListEx();

                // for ($i=0; $i<count($listdata2) ; $i++) { 
                //     $a2 = $listdata2[$i];
                //     $i++;
                // }

                //start_query
                // $query3 = "SELECT TOP 20 ( SELECT TOP 1 phrl.QuestionAnswerNum 
                //             FROM PatientHealthRecord phr 
                //             INNER JOIN PatientHealthRecordLine phrl
                //             ON phrl.TransactionNo = phr.TransactionNo 
                //             WHERE phr.RegistrationNo = r.RegistrationNo 
                //             AND phrl.QuestionID IN ('A.KDV.TDD', 'IOP.HR.D', 'KDV.TDR.D', 'REST.05', 'trg4.02')
                //             ORDER BY phrl.LastUpdateDateTime DESC
                //             ) as diastole 
                //             FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt3 = $conn->execute($query3);
                // while ($row3 = odbc_fetch_array($reslt3)) {
                //     $response3 = $row3;
                // }
                //end_query

    
                // $conn->executeQuery($query3, null, "Unknown Error");
                // $listdata3 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata3) ; $i++) { 
                //     $a3 = $listdata3[$i];
                //     $i++;
                // }

                //start_query
                // $query4 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr 
                //            INNER JOIN PatientHealthRecordLine phrl 
                //            ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo 
                //            AND phrl.QuestionID IN ('akktv13', 'bbank', 'bbyi', 'BRTBD', 'NUT.BB', 'QMCU0035', 'RJ.N.BBA')
                //            ORDER BY phrl.LastUpdateDateTime DESC 
                //            ) as berat_badan 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt4 = $conn->execute($query4);
                // while ($row4 = odbc_fetch_array($reslt4)) {
                //     $response4 = $row4;
                // }
                //end_query


                // $conn->executeQuery($query4, null, "Unknown Error");
                // $listdata4 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata4) ; $i++) { 
                //     $a4 = $listdata4[$i];
                //     $i++;
                // }

                //start_query
                // $query5 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr 
                //            INNER JOIN PatientHealthRecordLine phrl 
                //            ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo 
                //            AND phrl.QuestionID IN ('akktv14', 'NUT.TB', 'QMCU0034', 'RJ.N.TBA', 'tbank', 'TGBDN')
                //            ORDER BY phrl.LastUpdateDateTime DESC 
                //            ) as tinggi_badan 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt5 = $conn->execute($query5);
                // while ($row5 = odbc_fetch_array($reslt5)) {
                //     $response5 = $row5;
                // }
                //end_query


                // $conn->executeQuery($query5, null, "Unknown Error");
                // $listdata5 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata5) ; $i++) { 
                //     $a5 = $listdata5[$i];
                //     $i++;
                // }


                //start_query
                // $query6 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr 
                //            INNER JOIN PatientHealthRecordLine phrl 
                //            ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo 
                //            AND phrl.QuestionID IN ('MINT1.0101', 'RJ.N.LLP')
                //            ORDER BY phrl.LastUpdateDateTime DESC 
                //            ) as lingkar_perut 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt6 = $conn->execute($query6);
                // while ($row6 = odbc_fetch_array($reslt6)) {
                //     $response6 = $row6;
                // }
                //end_query
                

                // $conn->executeQuery($query6, null, "Unknown Error");
                // $listdata6 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata6) ; $i++) { 
                //     $a6 = $listdata6[$i];
                //     $i++;
                // }

                //start_query
                // $query7 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr 
                //            INNER JOIN PatientHealthRecordLine phrl 
                //            ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo 
                //            AND phrl.QuestionID IN ('A.RES.RS', 'RES.FREQ')
                //            ORDER BY phrl.LastUpdateDateTime DESC 
                //            ) as frekuensi_pernapasan 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt7 = $conn->execute($query7);
                // while ($row7 = odbc_fetch_array($reslt7)) {
                //     $response7 = $row7;
                // }
                //end_query

                // $conn->executeQuery($query7, null, "Unknown Error");
                // $listdata7 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata7) ; $i++) { 
                //     $a7 = $listdata7[$i];
                //     $i++;
                // }


                // $query8 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                //            FROM PatientHealthRecord phr 
                //            INNER JOIN PatientHealthRecordLine phrl 
                //            ON phrl.TransactionNo = phr.TransactionNo 
                //            WHERE phr.RegistrationNo = r.RegistrationNo 
                //            AND phrl.QuestionID IN ('KDV.DYT', 'QMCU0038')
                //            ORDER BY phrl.LastUpdateDateTime DESC ) as detak_jantung 
                //            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
                // $reslt8 = $conn->execute($query8);
                // while ($row8 = odbc_fetch_array($reslt8)) {
                //     $response8 = $row8;
                // }
                
                
                // $all = array_merge($query, $response2, $response3, $response4, $response5, $response6, $response7, $response8);
                // echo json_encode($all);

                // return $all;

                // $conn->executeQuery($query8, null, "Unknown Error");
                // $listdata8 = $conn->fetchArrayListEx();   

                // for ($i=0; $i<count($listdata8) ; $i++) { 
                //     $a8 = $listdata8[$i];
                //     $i++;
                // }

                // $all = array_merge($listdata[11], $listdata2[11], $listdata3[11]);


                // for ($i=0; $i<count($all) ; $i++) { 
                //     echo print_r($all);
                // }

                // var_dump($all);
                // die;

                // $json = implode(",", $all);

                // $json = json_encode($all);

                // $jsondecode = json_decode($json, true);

                // echo $jsondecode;

                // $request = array(
                //     "kdProviderPeserta" => "",
                //     "tglDaftar" => date('d-m-Y'),
                //     "noKartu" => $all["GuarantorCardNo"],
                //     "kdPoli" => "001", //kode poli harus diisi
                //     "keluhan" => null,
                //     "kunjSakit" => true,
                //     "sistole" =>  (int)$all["siastole"],
                //     "diastole" =>  (int)$all["diastole"],
                //     "beratBadan" => (int)$all["berat_badan"],
                //     "tinggiBadan" => (int)$all["tinggi_badan"],
                //     "respRate" => (int)$all["frekuensi_pernapasan"],
                //     "lingkarPerut" => (int)$all["lingkar_perut"],
                //     "heartRate" => (int)$all["detak_jantung"],
                //     "rujukBalik" => 0,
                //     "kdTkp"=>"10"
                // );


                // return $all;


                // $query2 = $conn->select(" (SELECT TOP 1 phrl.QuestionAnswerNum 
                //                           FROM PatientHealthRecord phr INNER JOIN PatientHealthRecordLine phrl ON phrl.TransactionNo = phr.TransactionNo 
                //                           WHERE phr.RegistrationNo = r.RegistrationNo AND phrl.QuestionID IN ('KDV.TDR.S', 'REST.06', 'A.KDV.TDS', 'IOP.HR.S', 'trg4.01')
                //                           ORDER BY phrl.LastUpdateDateTime DESC) as siastole ")
                //                ->from("Registration r")
                //                ->where("r.GuarantorID = '$this->kode'")
                //                ->top(50)
                //                ->execute();
                               
                // $query3 = $conn->select(" ( SELECT TOP 1 phrl.QuestionAnswerNum 
                //                             FROM PatientHealthRecord phr 
                //                             INNER JOIN PatientHealthRecordLine phrl
                //                             ON phrl.TransactionNo = phr.TransactionNo 
                //                             WHERE phr.RegistrationNo = r.RegistrationNo 
                //                             AND phrl.QuestionID IN ('A.KDV.TDD', 'IOP.HR.D', 'KDV.TDR.D', 'REST.05', 'trg4.02')
                //                             ORDER BY phrl.LastUpdateDateTime DESC
                //                             ) as diastole ")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();

                // $query4 = $conn->select(" (SELECT TOP 1 phrl.QuestionAnswerNum 
                //                         FROM PatientHealthRecord phr 
                //                         INNER JOIN PatientHealthRecordLine phrl 
                //                         ON phrl.TransactionNo = phr.TransactionNo 
                //                         WHERE phr.RegistrationNo = r.RegistrationNo 
                //                         AND phrl.QuestionID IN ('akktv13', 'bbank', 'bbyi', 'BRTBD', 'NUT.BB', 'QMCU0035', 'RJ.N.BBA')
                //                         ORDER BY phrl.LastUpdateDateTime DESC 
                //                         ) as berat_badan ")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();
                
                // $query5 = $conn->select("(SELECT TOP 1 phrl.QuestionAnswerNum 
                //                         FROM PatientHealthRecord phr 
                //                         INNER JOIN PatientHealthRecordLine phrl 
                //                         ON phrl.TransactionNo = phr.TransactionNo 
                //                         WHERE phr.RegistrationNo = r.RegistrationNo 
                //                         AND phrl.QuestionID IN ('akktv14', 'NUT.TB', 'QMCU0034', 'RJ.N.TBA', 'tbank', 'TGBDN')
                //                         ORDER BY phrl.LastUpdateDateTime DESC 
                //                         ) as tinggi_badan ")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();

                // $query6 = $conn->select("(SELECT TOP 1 phrl.QuestionAnswerNum 
                //                         FROM PatientHealthRecord phr 
                //                         INNER JOIN PatientHealthRecordLine phrl 
                //                         ON phrl.TransactionNo = phr.TransactionNo 
                //                         WHERE phr.RegistrationNo = r.RegistrationNo 
                //                         AND phrl.QuestionID IN ('MINT1.0101', 'RJ.N.LLP')
                //                         ORDER BY phrl.LastUpdateDateTime DESC 
                //                         ) as lingkar_perut")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();
                
                // $query7 = $conn->select("(SELECT TOP 1 phrl.QuestionAnswerNum 
                //                       FROM PatientHealthRecord phr 
                //                       INNER JOIN PatientHealthRecordLine phrl 
                //                       ON phrl.TransactionNo = phr.TransactionNo 
                //                       WHERE phr.RegistrationNo = r.RegistrationNo 
                //                       AND phrl.QuestionID IN ('A.RES.RS', 'RES.FREQ')
                //                       ORDER BY phrl.LastUpdateDateTime DESC 
                //                       ) as frekuensi_pernapasan ")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();

                // $query8 = $conn->select("(SELECT TOP 1 phrl.QuestionAnswerNum 
                //                         FROM PatientHealthRecord phr 
                //                         INNER JOIN PatientHealthRecordLine phrl 
                //                         ON phrl.TransactionNo = phr.TransactionNo 
                //                         WHERE phr.RegistrationNo = r.RegistrationNo 
                //                         AND phrl.QuestionID IN ('KDV.DYT', 'QMCU0038')
                //                         ORDER BY phrl.LastUpdateDateTime DESC ) as detak_jantung ")
                //                 ->from("Registration r")
                //                 ->where("r.GuarantorID = '$this->kode'")
                //                 ->top(50)
                //                 ->execute();

                                
       
                
                
                // for ($i=0; $i<count($query) ; $i++) { 
                //   for ($j=0; $j<count($query2) ; $j++) { 
                //     if($query[$i] == $query2[$j])
                //     {

                //     }
                //   }
                // }
                // $all = array_merge($query, $query2, $query3, $query4, $query5, $query6, $query7, $query8);


              // for ($i=0; $i<count($query) ; $i++) { 
              //   $arr = array_merge($query[$i], $query2[$i], $query3[$i], $query4[$i], $query5[$i], $query6[$i], $query7[$i], $query8[$i]);
              //   // echo json_encode($arr);
              //   return $arr;
              // }     
              
              // $all = array_merge_recursive($query, $query2);
              // echo gettype($arr);
                // echo json_encode($all);
            }


}
