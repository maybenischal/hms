<div id="assignDoctorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Assign Doctor</h3>
            <form action="/index.php?route=assign-doctor" method="POST" class="mt-4">
                <input type="hidden" name="patient_id" value="<?= $patientId ?>">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="doctor_id">
                        Select Doctor
                    </label>
                    <select name="doctor_id" id="doctor_id" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('assignDoctor')"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 