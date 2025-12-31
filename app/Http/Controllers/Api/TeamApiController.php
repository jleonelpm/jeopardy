<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamApiController extends Controller
{
    /**
     * HU-10: Actualizar puntaje del equipo
     */
    public function updateScore(Team $team, Request $request)
    {
        $request->validate([
            'points' => 'required|integer',
            'operation' => 'required|in:add,subtract,set',
        ]);

        switch ($request->operation) {
            case 'add':
                $team->addScore($request->points);
                break;
            case 'subtract':
                $team->subtractScore($request->points);
                break;
            case 'set':
                $team->update(['score' => $request->points]);
                break;
        }

        $team->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Puntaje actualizado correctamente.',
            'data' => $team
        ]);
    }
}
