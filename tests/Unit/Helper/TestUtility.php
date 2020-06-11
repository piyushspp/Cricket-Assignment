<?php
namespace Tests\Unit\Helper;

use SebastianBergmann\Timer\Timer as TimeRecorder;

class TestUtility
{
    const PASS = 'PASSED';
    const FAIL = 'FAILED';
    const ALL_OK = 'ALL OK';
    const CR_LF = "\r\n";
    const HEADING_TEXT = "Testcase Name|API URL / Method Name|Input|Test Status|Execution Time|Remarks";
    const HEADING_CONTENT =  self::HEADING_TEXT . self::CR_LF;
    const NO_ISSUES = "No tests have failed. Yay!";
    
    function __construct(){
        $this->logFile = fopen(env('UNIT_TESTCASE_FILE_PATH', storage_path('/logs/test-case-report.txt')), 'a');
    }
    
    public function arrangeInputs($data)
    {   
       return urldecode(http_build_query($data,'',', '));
    }
    
    private function arrangeInputsForLoggingPurposes($data=[])
    {
       return urldecode(http_build_query($data,'',', '));
    }
    
    /**
     * 
     * @param string $testInputs
     * @param string $testStatus
     * @param string $testName
     * @param string $testRemarks
     */
    public function writeToFile($testInputs='', $testStatus='',$testName='',$testRemarks='', $apiUrl='')
    {   
        $testInputs = is_array($testInputs) ? $this->arrangeInputsForLoggingPurposes($testInputs) : $testInputs;
        $output = $testName."|".$apiUrl."|".$testInputs . "|$testStatus|" . TimeRecorder::secondsToTimeString(TimeRecorder::stop())."|$testRemarks\r\n";
        fwrite($this->logFile, $output);
    }
    
    /**
     * This function is used to hit a request by Param
     * @param array $param 
     */
    public function runTestCaseRequestByUrl($objectReference = null, $param,$functionName,$status = self::PASS,$remarks = self::ALL_OK) 
    {
        try {
            $APIResponse = $objectReference->withHeaders([
                        'Token' => $param['token']
                    ])->json($param['method'], $param['url']);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            $status = self::FAIL;
            $remarks = str_replace("\n", " ", $ex->getMessage());
        } finally {
            $this->writeToFile('', $status, $functionName, $remarks);
        }
    }
    
    /**
     * This function is used to call api along with required requests inputs/params and write accordingly to text file
     * @param type $testCaseRef
     */
    public function executeTestCase($testCaseRef = null) 
    {
        $status = self::PASS;
        $remarks = self::ALL_OK;
        try {
            $APIResponse = $testCaseRef->withHeaders([
                        'Token'=> $testCaseRef->data['token']
                    ])->json($testCaseRef->data['method'],$testCaseRef->data['apiURL'].$testCaseRef->data['urlParams'],$testCaseRef->data['requestParams']);
            $APIResponse->assertStatus($testCaseRef->data['expectedHTTPCode']);
        } catch (\Exception $ex) {
            $status = self::FAIL;
            $remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            $this->writeToFile($testCaseRef->data['requestInputs'],$status,$testCaseRef->data['functionName'],$remarks,$testCaseRef->data['apiURL']);
        }
    }
    
    /**
     * This function is used to return formatted text as string
     * @param type $functionName
     * @return string
     */
    public function createConsoleText($functionName) 
    {
        return (implode(" ", preg_split('/(?<=\\w)(?=[A-Z])/',$functionName)));
    }
}
