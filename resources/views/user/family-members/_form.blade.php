<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="dps-label" for="name">FULL NAME</label>
        <input id="name" name="name" type="text"
               value="{{ old('name', $familyMember->name ?? '') }}"
               class="dps-input mt-2" required
               placeholder="Example: Samia Akter">
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="relation">RELATION</label>
        <input id="relation" name="relation" type="text"
               value="{{ old('relation', $familyMember->relation ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: Mother, Father, Sister">
        <x-input-error :messages="$errors->get('relation')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="age">AGE</label>
        <input id="age" name="age" type="number" min="0" max="120"
               value="{{ old('age', $familyMember->age ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 35">
        <x-input-error :messages="$errors->get('age')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="gender">GENDER</label>
        <select id="gender" name="gender" class="dps-input mt-2">
            <option class="text-slate-900" value="">Select Gender</option>
            <option class="text-slate-900" value="male" @selected(old('gender', $familyMember->gender ?? '') === 'male')>Male</option>
            <option class="text-slate-900" value="female" @selected(old('gender', $familyMember->gender ?? '') === 'female')>Female</option>
            <option class="text-slate-900" value="other" @selected(old('gender', $familyMember->gender ?? '') === 'other')>Other</option>
        </select>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="blood_group">BLOOD GROUP</label>
        <select id="blood_group" name="blood_group" class="dps-input mt-2">
            <option class="text-slate-900" value="">Select Blood Group</option>
            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                <option class="text-slate-900" value="{{ $group }}" @selected(old('blood_group', $familyMember->blood_group ?? '') === $group)>
                    {{ $group }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="height_cm">HEIGHT CM</label>
        <input id="height_cm" name="height_cm" type="number" step="0.01"
               value="{{ old('height_cm', $familyMember->height_cm ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 165">
        <x-input-error :messages="$errors->get('height_cm')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="weight_kg">WEIGHT KG</label>
        <input id="weight_kg" name="weight_kg" type="number" step="0.01"
               value="{{ old('weight_kg', $familyMember->weight_kg ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 60">
        <x-input-error :messages="$errors->get('weight_kg')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <label class="dps-label" for="medical_conditions">MEDICAL CONDITIONS</label>
        <textarea id="medical_conditions" name="medical_conditions" rows="4"
                  class="dps-input mt-2 resize-none"
                  placeholder="Example: Diabetes, asthma, high blood pressure">{{ old('medical_conditions', $familyMember->medical_conditions ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('medical_conditions')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <label class="dps-label" for="allergies">ALLERGIES</label>
        <textarea id="allergies" name="allergies" rows="4"
                  class="dps-input mt-2 resize-none"
                  placeholder="Example: Penicillin allergy, dust allergy">{{ old('allergies', $familyMember->allergies ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('allergies')" class="mt-2" />
    </div>
</div>