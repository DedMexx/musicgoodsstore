<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClientController extends MainController
{
    protected string $tableName = 'client';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Client::search($query)
                ->paginate(self::$perPage);
        } else {
            $table = Client::orderBy('last_name', 'ASC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('client.index', compact('table'))
            ->with('title', 'Клиенты')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create')
            ->with('title', 'Добавить клиента')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        try {
//            return $request->all();
            Client::storeOrUpdate($request);
            return redirect()->route('client.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'clients_email_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['email' => 'Клиент с таким e-mail уже существует']);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors(['phone' => 'Клиент с таким номером телефона уже существует']);
                }
            }
        }
    }

    public function show(Client $client)
    {
        return view('client.show', compact('client'))->with('title', 'Клиент «' . $client->last_name . ' '
            . $client->first_name . ' ' . $client->third_name . '»')->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('client.edit', compact('client'))
            ->with('title', 'Изменить клиента')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        try {
            Client::storeOrUpdate($request, $client);
            return redirect()->route('client.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'clients_email_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['email' => 'Клиент с таким e-mail уже существует']);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors(['phone' => 'Клиент с таким номером телефона уже существует']);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index');
    }
}
