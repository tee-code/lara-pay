<?php

namespace App\Repositories;
use App\Models\Transaction;

class TransactionRepository {

    public function create($fields)
    {
        return Transaction::create($fields);
    }

    public function getById($id)
    {
        return Transaction::findOrFail($id)->paginate(5);
    }

    public function getAll()
    {
        return Transaction::paginate(5);
    }

    public function findRef($ref)
    {
        $transaction = Transaction::where("reference", $ref)->pluck("reference");
        
        return $transaction->isEmpty() ? false : $transaction;
    } 
}