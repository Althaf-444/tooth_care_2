<?php

require_once 'BaseModel.php';

class Treatment extends BaseModel
{
    public $name;
    public $description;
    public $registration_fee;
    public $treatment_fee;
    public $is_active;

    protected function getTableName()
    {
        return "treatments";
    }

    protected function addNewRec()
    {
        $param = array(
            ':name' => $this->name,
            ':description' => $this->description,
            ':treatment_fee' => $this->treatment_fee,
            ':registration_fee' => $this->registration_fee,
            ':is_active' => $this->is_active
        );
        return $this->pm->run(
            "INSERT INTO 
            treatments(name, description,treatment_fee, registration_fee, is_active) 
            values(:name, :description, :treatment_fee, :registration_fee, :is_active)",
            $param
        );
    }

    protected function updateRec()
    {
        $param = array(
            ':name' => $this->name,
            ':description' => $this->description,
            ':treatment_fee' => $this->treatment_fee,
            ':registration_fee' => $this->registration_fee,
            ':is_active' => $this->is_active,
            ':id' => $this->id
        );

        return $this->pm->run(
            "UPDATE 
            treatments 
            SET 
                name = :name, 
                description = :description,
                treatment_fee = :treatment_fee,
                registration_fee = :registration_fee,
                is_active = :is_active 
            WHERE id = :id",
            $param
        );
    }

    function  deleteById($id)
    {
        $treatment = new Treatment();
        $treatment->deleteRec($id);

        if ($treatment) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }
    function createTreatment($name, $description, $treatment_fee, $registration_fee, $is_active = 1)
    {
        $userModel = new Treatment();

        

        $user = new Treatment();
        $user->name = $name;
        $user->description = $description;
        $user->registration_fee = $registration_fee;
        $user->treatment_fee = $treatment_fee;
        $user->is_active = $is_active;
        $user->addNewRec();

        if ($user) {
            return $user; // User created successfully
        } else {
            return false; // User creation failed (likely due to database error)
        }
    }
    

}
