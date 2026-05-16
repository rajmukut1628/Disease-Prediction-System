<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="dps-label" for="family_member_id">PROFILE</label>
        <select id="family_member_id" name="family_member_id" class="dps-input mt-2">
            <option class="text-slate-900" value="">My Own Profile</option>
            @foreach($familyMembers as $member)
                <option class="text-slate-900" value="{{ $member->id }}"
                    @selected(old('family_member_id', $healthRecord->family_member_id ?? '') == $member->id)>
                    {{ $member->name }} — {{ $member->relation ?? 'Family Member' }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('family_member_id')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="blood_pressure">BLOOD PRESSURE</label>
        <input id="blood_pressure" name="blood_pressure" type="text"
               value="{{ old('blood_pressure', $healthRecord->blood_pressure ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 120/80">
        <x-input-error :messages="$errors->get('blood_pressure')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="height_cm">HEIGHT CM</label>
        <input id="height_cm" name="height_cm" type="number" step="0.01"
               value="{{ old('height_cm', $healthRecord->height_cm ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 170">
        <x-input-error :messages="$errors->get('height_cm')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="weight_kg">WEIGHT KG</label>
        <input id="weight_kg" name="weight_kg" type="number" step="0.01"
               value="{{ old('weight_kg', $healthRecord->weight_kg ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 65">
        <x-input-error :messages="$errors->get('weight_kg')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="sugar_level">SUGAR LEVEL</label>
        <input id="sugar_level" name="sugar_level" type="number" step="0.01"
               value="{{ old('sugar_level', $healthRecord->sugar_level ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 110">
        <x-input-error :messages="$errors->get('sugar_level')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="heart_rate">HEART RATE</label>
        <input id="heart_rate" name="heart_rate" type="number"
               value="{{ old('heart_rate', $healthRecord->heart_rate ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 78">
        <x-input-error :messages="$errors->get('heart_rate')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="oxygen_level">OXYGEN LEVEL</label>
        <input id="oxygen_level" name="oxygen_level" type="number"
               value="{{ old('oxygen_level', $healthRecord->oxygen_level ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 98">
        <x-input-error :messages="$errors->get('oxygen_level')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="sleep_hours">SLEEP HOURS</label>
        <input id="sleep_hours" name="sleep_hours" type="number" step="0.01"
               value="{{ old('sleep_hours', $healthRecord->sleep_hours ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 7.5">
        <x-input-error :messages="$errors->get('sleep_hours')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="water_intake_ml">WATER INTAKE ML</label>
        <input id="water_intake_ml" name="water_intake_ml" type="number"
               value="{{ old('water_intake_ml', $healthRecord->water_intake_ml ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: 2000">
        <x-input-error :messages="$errors->get('water_intake_ml')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <label class="dps-label" for="notes">HEALTH NOTES</label>
        <textarea id="notes" name="notes" rows="5"
                  class="dps-input mt-2 resize-none"
                  placeholder="Example: Feeling weak today, mild headache, walked 30 minutes...">{{ old('notes', $healthRecord->notes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>

<div class="mt-6 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 p-5">
    <p class="text-cyan-100 font-black">BMI Auto Calculation</p>
    <p class="mt-2 text-sm text-cyan-100/80">
        Height and weight দিলে BMI automatically controller থেকে calculate হয়ে database-এ save হবে।
    </p>
</div>