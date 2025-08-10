<?php

namespace App\Livewire\Definitions;

use Livewire\Component;
use App\Models\Definition;
use App\Models\Type;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Edit extends Component
{
    use WithFileUploads;

    public $definition;
    public $definition_id;

    // Form fields
    public $name;
    public $code;
    public $barcode;
    public $madin;
    public $type_id;
    public $is_active;
    public $delivery_type;

    // Image handling
    public $new_image;
    public $current_image;
    public $remove_image = false;

    public function mount($definition_id)
    {
        try {
            $this->definition_id = $definition_id;
            $this->definition = Definition::findOrFail($definition_id);

            $this->name = $this->definition->name;
            $this->code = $this->definition->code;
            $this->barcode = $this->definition->barcode;
            $this->madin = $this->definition->madin;
            $this->type_id = $this->definition->type_id;
            $this->is_active = $this->definition->is_active;
            $this->delivery_type = $this->definition->delivery_type;

            if ($this->definition->image) {
                $this->current_image = asset('storage/' . $this->definition->image);
            }
        } catch (ModelNotFoundException $e) {
            flash()->addError('لم يتم العثور على التعريف.');
            return redirect()->route('definitions.create');
        } catch (\Exception $e) {
            flash()->addError('حدث خطأ أثناء تحميل بيانات التعريف.');
            return redirect()->route('definitions.create');
        }
    }

    public function removeImage()
    {
        $this->remove_image = true;
        $this->current_image = null;
        $this->new_image = null;
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('definitions', 'name')->ignore($this->definition_id),
                ],
                'code' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('definitions', 'code')->ignore($this->definition_id),
                ],
                'barcode' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('definitions', 'barcode')->ignore($this->definition_id),
                ],
                'madin' => 'nullable|string|max:255',
                'type_id' => 'required|exists:types,id',
                'is_active' => 'required',
                'delivery_type' => 'boolean',
                'new_image' => 'nullable|image|max:2048',
            ]);

            $updateData = [
                'name' => $this->name,
                'code' => $this->code,
                'barcode' => $this->barcode,
                'madin' => $this->madin,
                'type_id' => $this->type_id,
                'is_active' => $this->is_active,
                'delivery_type' => $this->delivery_type,
            ];

            if ($this->remove_image) {
                if ($this->definition->image && Storage::disk('public')->exists($this->definition->image)) {
                    Storage::disk('public')->delete($this->definition->image);
                }
                $updateData['image'] = null;
            } elseif ($this->new_image) {
                if ($this->definition->image && Storage::disk('public')->exists($this->definition->image)) {
                    Storage::disk('public')->delete($this->definition->image);
                }
                $path = $this->new_image->store('definitions', 'public');
                $updateData['image'] = $path;
            }

            $this->definition->update($updateData);

             $this->dispatch('definitionUpdated', id: $this->definition_id);

      

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            foreach ($errors as $error) {
                flash()->addWarning($error);
            }
        } catch (ModelNotFoundException $e) {
            flash()->addError('لم يتم العثور على التعريف.');
        } catch (\Exception $e) {
            flash()->addError('حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.definitions.edit', [
            'types' => Type::all(),
        ]);
    }
}
