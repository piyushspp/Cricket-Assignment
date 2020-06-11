<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Unit\Helper\TestUtility;
use SebastianBergmann\Timer\Timer as TimeRecorder;

class MatchesTeamsPlayersTest extends TestCase
{
    
    public static   $requestGetMethod,
                    $requestPostMethod,
                    $requestDeleteMethod,
                    $addTeamAPIUrl,
                    $teamsListAPIUrl,
                    $editTeamAPIUrl,
                    $teamNameByIdAPIUrl,
                    $addPlayerInSystemAPIUrl,
                    $editPlayerAPIUrl,
                    $allPlayerListAPIUrl,
                    $availablePlayersAPIUrl,
                    $assignPlayerToTeamAPIUrl,
                    $removePlayerFromTeamAPIUrl,
                    $teamPlayersAPIUrl,
                    $matchBetweenTeamsAPIUrl,
                    $matchResultOptions,
                    $numberOfMatchesOfATeamAPIUrl,
                    $pointsEarnedByTeamAPIUrl,
                    $teamsAndPointsTableAPIUrl,
                    $faker,
                    $testStatus,
                    $remarks,
                    $createTestUnitLogFile;
    
    public static function setUpBeforeClass() :void
    {
        self::$requestGetMethod    = 'GET';
        self::$requestPostMethod   = 'POST';
        self::$requestDeleteMethod = 'DELETE';
        self::$faker               = \Faker\Factory::create();
        self::$testStatus          = TestUtility::PASS;
        self::$remarks             = TestUtility::ALL_OK;
    }
      
    public function setUp():void 
    {
        parent::setUp();
        self::$addTeamAPIUrl   = env('API_BASE_URL') . 'team-add';
        self::$editTeamAPIUrl = env('API_BASE_URL') . 'team-edit';
        self::$teamsListAPIUrl = env('API_BASE_URL') . 'teams'; 
        self::$teamNameByIdAPIUrl = env('API_BASE_URL') . 'team-name/';
        self::$addPlayerInSystemAPIUrl = env('API_BASE_URL') . 'player-add';
        self::$editPlayerAPIUrl = env('API_BASE_URL') . 'player-edit';
        self::$allPlayerListAPIUrl = env('API_BASE_URL') . 'player-list';
        self::$availablePlayersAPIUrl = env('API_BASE_URL') . 'available-players';
        self::$assignPlayerToTeamAPIUrl = env('API_BASE_URL') . 'assign-playerto-team';
        self::$removePlayerFromTeamAPIUrl = env('API_BASE_URL') . 'remove-player-from-team';
        self::$teamPlayersAPIUrl = env('API_BASE_URL') . 'team-players/';
        self::$matchBetweenTeamsAPIUrl = env('API_BASE_URL') . 'play-match';
        self::$numberOfMatchesOfATeamAPIUrl = env('API_BASE_URL') . 'team-matches/';
        self::$pointsEarnedByTeamAPIUrl = env('API_BASE_URL') . 'team-points/';
        self::$teamsAndPointsTableAPIUrl = env('API_BASE_URL') . 'team-points-table';
        self::$createTestUnitLogFile      = fopen(env('UNIT_TESTCASE_FILE_PATH'), 'a');
        self::$matchResultOptions = [
            "0" => "teamOne",
            "1" => "teamTwo",
            "2" => "draw"
        ];    
    }
       
    public function testAddTeam()
    {   
        TimeRecorder::start();
        file_put_contents(env('UNIT_TESTCASE_FILE_PATH'), "");
        fwrite(self::$createTestUnitLogFile, TestUtility::HEADING_CONTENT);
        $requestInputs = [
            'name'    => self::$faker->name,
            'state'   => self::$faker->city,
            'logoUri' => \Illuminate\Http\UploadedFile::fake()->create('companyLogo.png'),
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        $teamId = "";
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$addTeamAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
            $teamId = $APIResponse->original['data']['teamId'];
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$addTeamAPIUrl);
            return $teamId;
        }
    }  
    
    /**
    * @depends testAddTeam
    */
    public function testEditTeam($teamId)
    {   
        TimeRecorder::start();
        $requestInputs = [
            'teamId'  => $teamId,
            'name'    => self::$faker->name,
            'state'   => self::$faker->city,
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$editTeamAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$editTeamAPIUrl);
        }
    }
    
    /**
    * @depends testAddTeam
    */
    public function testGetTeamNameById($teamId)
    {   
        TimeRecorder::start();
        $urlParams = [
            'teamId'  => $teamId,
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($urlParams, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$teamNameByIdAPIUrl.$urlParams['teamId']);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($urlParams, self::$testStatus,__FUNCTION__, self::$remarks,self::$teamNameByIdAPIUrl);
        }
    }
    
    public function testGetTeams()
    {   
        TimeRecorder::start();
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n");
        $requestInputs = "----";
        $teams = [];
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$teamsListAPIUrl);
            $APIResponse->assertStatus(200);
            $teams = [
                'teamOne' => $APIResponse->original[0]['teamId'],
                'teamTwo' => $APIResponse->original[1]['teamId'],
                'draw'    => 'draw',
            ];    
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$teamsListAPIUrl);
            return $teams;
        }
    }
    
    public function testAddPlayerInSystem()
    {   
        TimeRecorder::start();
        $requestInputs = [
            'firstName'         => self::$faker->name,
            'lastName'          => self::$faker->name,
            'imageUri'          => \Illuminate\Http\UploadedFile::fake()->create('playerImage.png'),
            'playerJersyNumber' => (string) self::$faker->numberBetween(1, 99),
            'country'           => self::$faker->country,
            'matches'           => (string) self::$faker->numberBetween(1, 300),
            'run'               => (string) self::$faker->numberBetween(1, 20000),
            'highestScore'      => (string) self::$faker->numberBetween(1, 400),
            'fifties'           => (string) self::$faker->numberBetween(1, 90),
            'hundreds'          => (string) self::$faker->numberBetween(1, 90),
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        $playerId ="";
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$addPlayerInSystemAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
            $playerId = $APIResponse->original['data']['playerId'];
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$addPlayerInSystemAPIUrl);
            return $playerId;
        }
    }
    
    /**
    * @depends testAddPlayerInSystem
    */
    public function testEditPlayerSystem($playerId)
    {   
        TimeRecorder::start();
        $requestInputs = [
            'playerId'          => $playerId,
            'firstName'         => self::$faker->name,
            'lastName'          => self::$faker->name,
            'playerJersyNumber' => (string) self::$faker->numberBetween(1, 99),
            'country'           => self::$faker->country,
            'matches'           => (string) self::$faker->numberBetween(1, 300),
            'run'               => (string) self::$faker->numberBetween(1, 20000),
            'highestScore'      => (string) self::$faker->numberBetween(1, 400),
            'fifties'           => (string) self::$faker->numberBetween(1, 90),
            'hundreds'          => (string) self::$faker->numberBetween(1, 90),
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$editPlayerAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$editPlayerAPIUrl);
        }
    }
    
    
    public function testAllPlayersListInSystem()
    {   
        TimeRecorder::start();
        $requestInputs = [];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$allPlayerListAPIUrl);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$allPlayerListAPIUrl);
        }
    }
    
    public function testAvailablePlayersInSystem()
    {   
        TimeRecorder::start();
        $requestInputs = [];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$availablePlayersAPIUrl);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$availablePlayersAPIUrl);
        }
    }
    
    /**
    * @depends testAddTeam
    * @depends testAddPlayerInSystem
    */
    public function testAssignPlayerToTeam($teamId,$playerId)
    {   
        TimeRecorder::start();
        $requestInputs = [
            'teamId'   => $teamId,
            'playerId' => $playerId,
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$assignPlayerToTeamAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$assignPlayerToTeamAPIUrl);
        }
    }
    
    /**
    * @depends testAddTeam
    */
    public function testGetTeamPlayers($teamId)
    {   
        TimeRecorder::start();
        $urlParams = [
            'teamId'  => $teamId,
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($urlParams, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$teamPlayersAPIUrl.$urlParams['teamId']);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($urlParams, self::$testStatus,__FUNCTION__, self::$remarks,self::$teamPlayersAPIUrl);
        }
    }
    
    /**
    * @depends testAddTeam
    * @depends testAddPlayerInSystem
    */
    public function testRemovePlayerFromTeam($teamId,$playerId)
    {   
        TimeRecorder::start();
        $requestInputs = [
            'teamId'   => $teamId,
            'playerId' => $playerId,
        ];
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestDeleteMethod,self::$removePlayerFromTeamAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$removePlayerFromTeamAPIUrl);
        }
    }
    
    /**
    * @depends testGetTeams
    */
    public function testMatchBetweenTeams($teams)
    {   
        TimeRecorder::start();
        $randomResult = array_rand(self::$matchResultOptions);
        $requestInputs = [
            'teamOne' => $teams['teamOne'],
            'teamTwo' => $teams['teamTwo'],
            'winner'  => self::$matchResultOptions[$randomResult]
        ];      
        
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestPostMethod,self::$matchBetweenTeamsAPIUrl,$requestInputs);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$matchBetweenTeamsAPIUrl);
        }
    }
    
    /**
    * @depends testGetTeams
    */
    public function testNumberOfMatchesOfATeam($teams)
    {   
        TimeRecorder::start();
        $urlParams = [
            'teamId' => $teams['teamOne'],
        ];      
        
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($urlParams, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$numberOfMatchesOfATeamAPIUrl.$urlParams['teamId']);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($urlParams, self::$testStatus,__FUNCTION__, self::$remarks,self::$numberOfMatchesOfATeamAPIUrl);
        }
    }
    
    /**
    * @depends testGetTeams
    */
    public function testTotalPointsEarnedByTeam($teams)
    {   
        TimeRecorder::start();
        $urlParams = [
            'teamId' => $teams['teamTwo'],
        ];      
        
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($urlParams, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$pointsEarnedByTeamAPIUrl.$urlParams['teamId']);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($urlParams, self::$testStatus,__FUNCTION__, self::$remarks,self::$pointsEarnedByTeamAPIUrl);
        }
    }
    
    public function testTeamsAndTheirPointsTable()
    {   
        TimeRecorder::start();
        $requestInputs = [];      
        
        fwrite(STDERR, "\n------------------------".print_r((new TestUtility())->createConsoleText(__FUNCTION__), TRUE).":------------------------- \n" . print_r($requestInputs, TRUE)."\n\n");
        
        try {
            $APIResponse = $this->json(self::$requestGetMethod,self::$teamsAndPointsTableAPIUrl);
            $APIResponse->assertStatus(200);
        } catch (\Exception $ex) {
            self::$testStatus = TestUtility::FAIL;
            self::$remarks = str_replace("\n", " ", $ex->getMessage()); 
        } finally{
            (new TestUtility())->writeToFile($requestInputs, self::$testStatus,__FUNCTION__, self::$remarks,self::$teamsAndPointsTableAPIUrl);
        }
    }
}
