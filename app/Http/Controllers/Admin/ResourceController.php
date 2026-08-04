<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Schema-driven CRUD for simple content entities.
 * Subclasses declare the model, route key, labels and field schema.
 *
 * Field: ['name' => 'title', 'label' => 'Título', 'type' => 'text|textarea|number|image|checkbox', 'required' => bool]
 */
abstract class ResourceController extends Controller
{
    abstract protected function model(): string;

    abstract protected function route(): string;

    /** @return array{0:string,1:string} [singular, plural] */
    abstract protected function labels(): array;

    abstract protected function fields(): array;

    protected function titleField(): string
    {
        return 'title';
    }

    public function index(): View
    {
        return view('admin.resource.index', $this->viewData([
            'records' => $this->model()::query()->orderBy('sort')->orderBy('id')->get(),
        ]));
    }

    public function create(): View
    {
        return view('admin.resource.form', $this->viewData(['record' => new ($this->model())]));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->model()::create($this->data($request));

        return redirect($this->indexUrl())->with('status', $this->labels()[0].' criado.');
    }

    public function edit(string $id): View
    {
        return view('admin.resource.form', $this->viewData(['record' => $this->find($id)]));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $record = $this->find($id);
        $record->update($this->data($request, $record));

        return redirect($this->indexUrl())->with('status', $this->labels()[0].' actualizado.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->find($id)->delete();

        return back()->with('status', $this->labels()[0].' eliminado.');
    }

    protected function find(string $id): Model
    {
        return $this->model()::findOrFail($id);
    }

    protected function indexUrl(): string
    {
        return route('admin.'.$this->route().'.index');
    }

    protected function viewData(array $extra): array
    {
        return array_merge([
            'route' => $this->route(),
            'labels' => $this->labels(),
            'fields' => $this->fields(),
            'titleField' => $this->titleField(),
        ], $extra);
    }

    protected function data(Request $request, ?Model $record = null): array
    {
        $rules = [];
        foreach ($this->fields() as $f) {
            if (($f['required'] ?? false) && $f['type'] !== 'image') {
                $rules[$f['name']] = 'required';
            }
        }
        $request->validate($rules);

        $data = [];
        foreach ($this->fields() as $f) {
            $name = $f['name'];
            $type = $f['type'];

            if ($type === 'image') {
                if ($request->hasFile($name.'_file')) {
                    $data[$name] = '/storage/'.$request->file($name.'_file')->store('cms', 'public');
                } elseif ($request->filled($name)) {
                    $data[$name] = $request->input($name);
                } elseif ($record) {
                    $data[$name] = $record->{$name};
                }

                continue;
            }

            if ($type === 'checkbox') {
                $data[$name] = $request->boolean($name);

                continue;
            }

            $data[$name] = $request->input($name);

            if (! empty($f['translatable'])) {
                $data[$name.'_en'] = $request->input($name.'_en');
            }
        }

        return $this->transform($data, $request, $record);
    }

    /** Hook for subclasses needing derived fields (slug, dates, ...). */
    protected function transform(array $data, Request $request, ?Model $record): array
    {
        return $data;
    }
}
