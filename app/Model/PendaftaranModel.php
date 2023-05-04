<?php
namespace Rscharitas\MVCPCARE\Model;
use Rscharitas\MVCPCARE\App\Connection;

class PendaftaranModel {

        private string $kode = "BPJ0001";
        
            function queryantrian(): void
            {
                $conn = new Connection;

                $query = "SELECT TOP 20 r.RegistrationDate as Tanggal_Daftar,
                        r.GuarantorCardNo as NoKartu, 
                        r.ServiceUnitID as KodePoli, 
                        r.GuarantorID as GuarantorID, 
                        r.GuarantorCardNo as GuarantorCardNo FROM Registration r where r.GuarantorID = '$this->kode'";
        
                $conn->executeQuery($query, null, "Unknown Error");
                $listdata = $conn->fetchArrayListEx();

                for ($i=0; $i<count($listdata) ; $i++) { 
                    $a = $listdata[$i];
                    $i++;
                }


                $query2 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr INNER JOIN PatientHealthRecordLine phrl ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo AND phrl.QuestionID IN ('KDV.TDR.S', 'REST.06', 'A.KDV.TDS', 'IOP.HR.S', 'trg4.01')
                           ORDER BY phrl.LastUpdateDateTime DESC ) as siastole 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query2, null, "Unknown Error");
                $listdata2 = $conn->fetchArrayListEx();

                for ($i=0; $i<count($listdata2) ; $i++) { 
                    $a2 = $listdata2[$i];
                    $i++;
                }

                $query3 = "SELECT TOP 20 ( SELECT TOP 1 phrl.QuestionAnswerNum 
                            FROM PatientHealthRecord phr 
                            INNER JOIN PatientHealthRecordLine phrl
                            ON phrl.TransactionNo = phr.TransactionNo 
                            WHERE phr.RegistrationNo = r.RegistrationNo 
                            AND phrl.QuestionID IN ('A.KDV.TDD', 'IOP.HR.D', 'KDV.TDR.D', 'REST.05', 'trg4.02')
                            ORDER BY phrl.LastUpdateDateTime DESC
                            ) as diastole 
                            FROM Registration r WHERE r.GuarantorID = '$this->kode'";
    
                $conn->executeQuery($query3, null, "Unknown Error");
                $listdata3 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata3) ; $i++) { 
                    $a3 = $listdata3[$i];
                    $i++;
                }

                $query4 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr 
                           INNER JOIN PatientHealthRecordLine phrl 
                           ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo 
                           AND phrl.QuestionID IN ('akktv13', 'bbank', 'bbyi', 'BRTBD', 'NUT.BB', 'QMCU0035', 'RJ.N.BBA')
                           ORDER BY phrl.LastUpdateDateTime DESC 
                           ) as berat_badan 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query4, null, "Unknown Error");
                $listdata4 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata4) ; $i++) { 
                    $a4 = $listdata4[$i];
                    $i++;
                }

                $query5 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr 
                           INNER JOIN PatientHealthRecordLine phrl 
                           ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo 
                           AND phrl.QuestionID IN ('akktv14', 'NUT.TB', 'QMCU0034', 'RJ.N.TBA', 'tbank', 'TGBDN')
                           ORDER BY phrl.LastUpdateDateTime DESC 
                           ) as tinggi_badan 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query5, null, "Unknown Error");
                $listdata5 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata5) ; $i++) { 
                    $a5 = $listdata5[$i];
                    $i++;
                }

                $query6 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr 
                           INNER JOIN PatientHealthRecordLine phrl 
                           ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo 
                           AND phrl.QuestionID IN ('MINT1.0101', 'RJ.N.LLP')
                           ORDER BY phrl.LastUpdateDateTime DESC 
                           ) as lingkar_perut 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query6, null, "Unknown Error");
                $listdata6 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata6) ; $i++) { 
                    $a6 = $listdata6[$i];
                    $i++;
                }


                $query7 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr 
                           INNER JOIN PatientHealthRecordLine phrl 
                           ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo 
                           AND phrl.QuestionID IN ('A.RES.RS', 'RES.FREQ')
                           ORDER BY phrl.LastUpdateDateTime DESC 
                           ) as frekuensi_pernapasan 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query7, null, "Unknown Error");
                $listdata7 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata7) ; $i++) { 
                    $a7 = $listdata7[$i];
                    $i++;
                }


                $query8 = "SELECT TOP 20 (SELECT TOP 1 phrl.QuestionAnswerNum 
                           FROM PatientHealthRecord phr 
                           INNER JOIN PatientHealthRecordLine phrl 
                           ON phrl.TransactionNo = phr.TransactionNo 
                           WHERE phr.RegistrationNo = r.RegistrationNo 
                           AND phrl.QuestionID IN ('KDV.DYT', 'QMCU0038')
                           ORDER BY phrl.LastUpdateDateTime DESC ) as detak_jantung 
                           FROM Registration r WHERE r.GuarantorID = '$this->kode'";

                $conn->executeQuery($query8, null, "Unknown Error");
                $listdata8 = $conn->fetchArrayListEx();   

                for ($i=0; $i<count($listdata8) ; $i++) { 
                    $a8 = $listdata8[$i];
                    $i++;
                }

                // $all = array_merge($listdata[11], $listdata2[11], $listdata3[11]);

                $all = array_merge($a, $a2, $a3, $a4, $a5, $a6, $a7, $a8);

                // echo gettype($all);
                echo json_encode($all);
                
            }


}
